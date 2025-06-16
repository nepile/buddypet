<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerController extends BaseController
{
    public function showHomeCustomer()
    {
        $title = 'Beranda Produk';
        return view('customer/home', compact('title'));
    }
}
