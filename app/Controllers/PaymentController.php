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

    public function showPaymentPage()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil semua order dengan status 'unpaid' milik user
        $pendingOrders = $this->orderModel
            ->select('orders.*, products.name as product_name, products.image')
            ->join('products', 'products.product_id = orders.product_id')
            ->where([
                'orders.user_id' => $userId,
                'orders.status' => 'unpaid'
            ])
            ->findAll();

        if (empty($pendingOrders)) {
            return redirect()->to('/orders')->with('error', 'Tidak ada pembayaran yang perlu diproses.');
        }

        $data = [
            'total' => array_sum(array_column($pendingOrders, 'total_amount')),
            'user_id' => $userId,
            'orders' => $pendingOrders,
            'title' => 'Pembayaran'
        ];

        return view('customer/payment', $data);
    }

    public function confirmPayment()
    {
        $userId = session()->get('user_id');
        $paymentMethod = $this->request->getPost('payment_method');

        if (!$userId || !$paymentMethod) {
            return redirect()->back()->with('error', 'Data tidak lengkap. Silakan coba lagi.');
        }

        // Ambil semua order unpaid milik user
        $unpaidOrders = $this->orderModel
            ->where([
                'user_id' => $userId,
                'status' => 'unpaid'
            ])
            ->findAll();

        if (empty($unpaidOrders)) {
            return redirect()->to('/orders')->with('error', 'Tidak ada pembayaran yang perlu dikonfirmasi.');
        }

        // Update semua order menjadi completed
        foreach ($unpaidOrders as $order) {
            $this->orderModel->update($order['order_id'], [
                'status' => 'completed',
                'payment_method' => $paymentMethod,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/transactions')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }


}