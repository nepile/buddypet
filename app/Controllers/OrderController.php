<?php

namespace App\Controllers;

use App\Models\Order;

class OrderController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function createOrder()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        $cartItems = $this->orderModel->where(['user_id' => $userId, 'status' => 'cart'])->findAll();

        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Cart is empty');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            $product = $this->db->table('products')->where('id', $item['product_id'])->get()->getRowArray();
            if ($product['stock'] < $item['quantity']) {
                return redirect()->to('/cart')->with('error', 'Insufficient stock for ' . $product['name']);
            }
        }

        // Update cart items to pending order and reduce stock
        foreach ($cartItems as $item) {
            $this->orderModel->update($item['order_id'], ['status' => 'pending']);
            $this->db->table('products')
                     ->where('id', $item['product_id'])
                     ->set('stock', 'stock - ' . (int)$item['quantity'], false)
                     ->update();
        }

        return redirect()->to('/payment/process/' . $cartItems[0]['order_id'])->with('success', 'Order created successfully');
    }

    public function viewOrders()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        $data['orders'] = $this->orderModel->select('orders.*, products.name')
                                           ->join('products', 'products.id = orders.product_id')
                                           ->where(['user_id' => $userId, 'status !=' => 'cart'])
                                           ->findAll();
        return view('orders/view', $data);
    }
}