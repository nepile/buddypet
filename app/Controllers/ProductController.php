<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;

class ProductController extends BaseController
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function showProductManagement()
    {
        $data = [
            'title'     => 'Manajemen Produk',
            'products'  => $this->product->findAll(),
        ];
        return view('admin/product-management', $data);
    }

    public function store()
    {
        $image = $this->request->getFile('image');
        $imageName = '';

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move('img/products', $imageName);
        }

        $this->product->save([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'image'       => $imageName,
        ]);

        return redirect()->to('product-management')->with('success', 'Berhasil menambahkan produk.');
    }

    public function update($productId)
    {
        $product = $this->product->find($productId);
        $image = $this->request->getFile('image');

        $imageName = $product['image'];
        if ($image && $image->isValid() && !$image->hasMoved()) {
            if (file_exists('img/products/' . $imageName)) {
                unlink('img/products/' . $imageName);
            }
            $imageName = $image->getRandomName();
            $image->move('img/products', $imageName);
        }

        $this->product->update($productId, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'image'       => $imageName,
        ]);

        return redirect()->to('product-management')->with('info', 'Berhasil memperbarui produk.');;
    }

    public function delete($productId)
    {
        $product = $this->product->find($productId);
        if ($product && file_exists('img/products/' . $product['image'])) {
            unlink('img/products/' . $product['image']);
        }
        $this->product->delete($productId);
        return redirect()->back();
    }
}
