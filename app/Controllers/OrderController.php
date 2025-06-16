<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;
use CodeIgniter\Controller;

class OrderController extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $data['orders'] = $orderModel->findAll();
        $data['products'] = $productModel->findAll();

        return view('orders/index', $data);
    }

    public function create()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();

        return view('orders/create', $data);
    }

    public function store()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();

        $productId = $this->request->getPost('product_id');
        $quantity  = (int)$this->request->getPost('quantity');

        $product = $productModel->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($product['stock'] < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        // Kurangi stok
        $productModel->update($productId, [
            'stock' => $product['stock'] - $quantity
        ]);

        // Simpan order
        $orderModel->insert([
            'customer_name' => $this->request->getPost('customer_name'),
            'product_id'    => $productId,
            'quantity'      => $quantity,
            'status'        => $this->request->getPost('status'),
        ]);

        return redirect()->to('/orders')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();

        $order = $orderModel->find($id);
        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $data['order'] = $order;
        $data['products'] = $productModel->findAll();

        return view('orders/edit', $data);
    }

    public function update($id)
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();

        $orderLama = $orderModel->find($id);
        if (!$orderLama) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $productIdBaru = $this->request->getPost('product_id');
        $quantityBaru  = (int)$this->request->getPost('quantity');

        $productBaru = $productModel->find($productIdBaru);
        if (!$productBaru) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Kembalikan stok lama
        $productLama = $productModel->find($orderLama['product_id']);
        $productModel->update($productLama['id'], [
            'stock' => $productLama['stock'] + $orderLama['quantity']
        ]);

        // Cek stok produk baru
        if ($productBaru['stock'] < $quantityBaru) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        // Kurangi stok produk baru
        $productModel->update($productIdBaru, [
            'stock' => $productBaru['stock'] - $quantityBaru
        ]);

        // Update order
        $orderModel->update($id, [
            'customer_name' => $this->request->getPost('customer_name'),
            'product_id'    => $productIdBaru,
            'quantity'      => $quantityBaru,
            'status'        => $this->request->getPost('status'),
        ]);

        return redirect()->to('/orders')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();

        $order = $orderModel->find($id);
        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Kembalikan stok
        $product = $productModel->find($order['product_id']);
        if ($product) {
            $productModel->update($product['id'], [
                'stock' => $product['stock'] + $order['quantity']
            ]);
        }

        // Hapus order
        $orderModel->delete($id);

        return redirect()->to('/orders')->with('success', 'Pesanan berhasil dihapus.');
    }
}
