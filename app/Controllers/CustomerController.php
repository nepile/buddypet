<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerController extends BaseController
{
    public function showHomeCustomer()
    {
        $product = new Product();

        $data = [
            'title'     => 'Beranda Produk',
            'products'  => $product->findAll(),
        ];
        return view('customer/home', $data);
    }

    public function showDetailProduct($productId)
    {
        $product = new Product();
        $selectedProduct = $product->where('product_id', $productId)->first();
        
        $data = [
            'title'     => $selectedProduct['name'],
            'product'   => $selectedProduct,
        ];
        return view('customer/product-detail', $data);
    }
}
