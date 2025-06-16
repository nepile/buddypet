<?php

namespace App\Controllers;

use App\Models\Order;

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
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $product = $this->db->table('products')->where('id', $productId)->get()->getRowArray();
        
        if (!$product) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }

        if ($product['stock'] < $quantity) {
            return redirect()->to('/products')->with('error', 'Insufficient stock');
        }

        $cartItem = [
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $product['price'],
            'total_amount' => $product['price'] * $quantity,
            'status' => 'cart'
        ];

        $this->orderModel->insert($cartItem);
        return redirect()->to('/cart')->with('success', 'Product added to cart');
    }

    public function viewCart()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        $data['cart_items'] = $this->orderModel->select('orders.*, products.name')
                                               ->join('products', 'products.id = orders.product_id')
                                               ->where(['user_id' => $userId, 'status' => 'cart'])
                                               ->findAll();
        $data['total'] = $this->orderModel->selectSum('total_amount', 'total')
                                          ->where(['user_id' => $userId, 'status' => 'cart'])
                                          ->first()['total'] ?: 0;
        return view('cart/view', $data);
    }

    public function updateCart()
    {
        $userId = session()->get('user_id');
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $product = $this->db->table('products')->where('id', $productId)->get()->getRowArray();
        if ($product['stock'] < $quantity) {
            return redirect()->to('/cart')->with('error', 'Insufficient stock');
        }

        $totalAmount = $product['price'] * $quantity;
        $this->orderModel->where(['user_id' => $userId, 'product_id' => $productId, 'status' => 'cart'])
                         ->update(['quantity' => $quantity, 'total_amount' => $totalAmount]);
        return redirect()->to('/cart')->with('success', 'Cart updated');
    }

    public function removeFromCart($productId)
    {
        $userId = session()->get('user_id');
        $this->orderModel->where(['user_id' => $userId, 'product_id' => $productId, 'status' => 'cart'])
                         ->delete();
        return redirect()->to('/cart')->with('success', 'Product removed from cart');
    }
}