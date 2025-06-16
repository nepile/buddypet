<?php

namespace App\Database\Seeds;

use App\Models\Product;
use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $product = new Product();

        $product->insert([
            // 'product_id'    => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name'          => 'Whiskas',
            'description'   => 'this is so fire',
            'price'         => 150000,
            'stock'         => 15,
            'image'         => 'whiskas.jpg'
        ]);
    }
}
