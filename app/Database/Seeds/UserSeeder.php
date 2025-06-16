<?php

namespace App\Database\Seeds;

use App\Models\User;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->insert([
            'email'     => 'neville@gmail.com',
            'name'  => 'Neville Jeremy',
            'password'  => password_hash('123neville456', PASSWORD_DEFAULT),
            'role'  => 'customer'
        ]);
    }
}
