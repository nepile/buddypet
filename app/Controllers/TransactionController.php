<?php

namespace App\Controllers;

use App\Models\Order;

class TransactionController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orders = $this->orderModel
            ->select('orders.*, products.name as product_name, products.image')
            ->join('products', 'products.product_id = orders.product_id')
            ->where('orders.user_id', $userId)
            ->whereIn('orders.status', ['unpaid', 'completed'])
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

        return view('customer/transactions', [
            'orders' => $orders,
            'title' => 'Histori Transaksi'
        ]);
    }

    public function delete($orderId)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }   

        $order = $this->orderModel->where([
            'order_id' => $orderId,
            'user_id' => $userId,
            'status' => 'unpaid'
        ])->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak dapat dihapus.');
        }

        $this->orderModel->delete($orderId);

        return redirect()->back()->with('success', 'Order berhasil dihapus.');
    }
    
}
