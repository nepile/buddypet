<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use App\Models\Order;
use Ramsey\Uuid\Uuid;

class CartController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function addToCart()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Jumlah harus lebih dari 0.');
        }

        $productModel = new Product();
        $product = $productModel->where('product_id', $productId)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($product['stock'] < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak cukup.');
        }

        // Cek apakah item sudah ada di keranjang
        $existing = $this->orderModel
            ->where(['user_id' => $userId, 'product_id' => $productId, 'status' => 'cart'])
            ->first();

        
        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            if ($product['stock'] < $newQty) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk jumlah total.');
            }

            $this->orderModel->update($existing['order_id'], [
                'quantity' => $newQty,
                'total_amount' => $product['price'] * $newQty
            ]);
        } else {
            try {
                $this->orderModel->insert([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product['price'],
                    'total_amount' => $product['price'] * $quantity,
                    'status' => 'cart'
                ]);

            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }

        return redirect()->to('/cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function showCart()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melihat keranjang.');
        }

        try {
            $data['cart_items'] = $this->orderModel
                ->select('orders.*, products.name, products.image')
                ->join('products', 'products.product_id = orders.product_id')
                ->where(['user_id' => $userId, 'status' => 'cart'])
                ->findAll();

            $data['total'] = $this->orderModel
                ->selectSum('total_amount', 'total')
                ->where(['user_id' => $userId, 'status' => 'cart'])
                ->first()['total'] ?? 0;

            $data['title'] = 'Keranjang Belanja';
        } catch (\Exception $e) {
            log_message('error', 'Cart loading error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat keranjang.');
        }

        return view('customer/cart', $data);
    }

    public function updateCart()
    {
        $userId = session()->get('user_id');
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        if (!$productId || !Uuid::isValid($productId)) {
            return redirect()->to('/cart')->with('error', 'ID produk tidak valid.');
        }

        if ($quantity <= 0) {
            try {
                $this->orderModel
                    ->where(['user_id' => $userId, 'product_id' => $productId, 'status' => 'cart'])
                    ->delete();
                return redirect()->to('/cart')->with('success', 'Produk dihapus dari keranjang.');
            } catch (\Exception $e) {
                log_message('error', 'Delete on updateCart error: ' . $e->getMessage());
                return redirect()->to('/cart')->with('error', 'Gagal menghapus produk.');
            }
        }

        $productModel = new Product();
        $product = $productModel->where('product_id', $productId)->first();

        if (!$product) {
            return redirect()->to('/cart')->with('error', 'Produk tidak ditemukan.');
        }

        if ($product['stock'] < $quantity) {
            return redirect()->to('/cart')->with('error', 'Stok tidak cukup.');
        }

        try {
            $this->orderModel
                ->where(['user_id' => $userId, 'product_id' => $productId, 'status' => 'cart'])
                ->set([
                    'quantity' => $quantity,
                    'total_amount' => $product['price'] * $quantity
                ])
                ->update();
        } catch (\Exception $e) {
            log_message('error', 'Update cart error: ' . $e->getMessage());
            return redirect()->to('/cart')->with('error', 'Gagal memperbarui keranjang.');
        }

        return redirect()->to('/cart')->with('success', 'Keranjang diperbarui.');
    }

    public function removeFromCart($productId)
    {
        $userId = session()->get('user_id');

        if (!$productId || !Uuid::isValid($productId)) {
            return redirect()->to('/cart')->with('error', 'ID produk tidak valid.');
        }

        try {
            $this->orderModel
                ->where(['user_id' => $userId, 'product_id' => $productId, 'status' => 'cart'])
                ->delete();
        } catch (\Exception $e) {
            log_message('error', 'Remove cart error: ' . $e->getMessage());
            return redirect()->to('/cart')->with('error', 'Gagal menghapus produk.');
        }

        return redirect()->to('/cart')->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil item keranjang user
        $cartItems = $this->orderModel
            ->where(['user_id' => $userId, 'status' => 'cart'])
            ->findAll();

        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Keranjang Anda kosong.');
        }

        // Cek stok untuk setiap item
        $productModel = new Product();
        foreach ($cartItems as $item) {
            $product = $productModel->where('product_id', $item['product_id'])->first();
            if (!$product || $product['stock'] < $item['quantity']) {
                return redirect()->to('/cart')->with('error', 'Stok tidak cukup untuk produk: ' . ($product['name'] ?? 'Unknown'));
            }
        }

        // Ubah status ke "unpaid" dan kurangi stok produk
        foreach ($cartItems as $item) {
            $this->orderModel->update($item['order_id'], ['status' => 'unpaid']);

            $productModel->where('product_id', $item['product_id'])
                ->set('stock', 'stock - ' . (int)$item['quantity'], false)
                ->update();
        }

        // Redirect ke halaman proses pembayaran
        return redirect()->to('/payment')->with('success', 'Checkout berhasil. Silakan lanjutkan pembayaran.');
    }

}
