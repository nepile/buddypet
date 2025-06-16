<?php

namespace App\Controllers;

use App\Models\Order;

class PaymentController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function process($orderId)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        $order = $this->orderModel->where('order_id', $orderId)->first();
        
        if (!$order || $order['user_id'] != $userId || $order['status'] != 'pending') {
            return redirect()->to('/orders')->with('error', 'Invalid order');
        }

        $data['order'] = $order;
        return view('payment/process', $data);
    }

    public function confirmPayment()
    {
        $userId = session()->get('user_id');
        $orderId = $this->request->getPost('order_id');
        $paymentMethod = $this->request->getPost('payment_method');

        $order = $this->orderModel->where('order_id', $orderId)->first();
        
        if (!$order || $order['user_id'] != $userId || $order['status'] != 'pending') {
            return redirect()->to('/orders')->with('error', 'Invalid order');
        }

        // Process payment (integrate with payment gateway here)
        $this->orderModel->update($orderId, ['status' => 'completed']);

        return redirect()->to('/orders')->with('success', 'Payment completed successfully');
    }
}