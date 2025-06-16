<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function showLogin()
    {
        $title = 'Login';
        return view('auth/login', compact('title'));
    }

    public function login()
    {
        $session = session();
        $model = new User();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');


        $user = $model->where('email', $email)->first();
        $passwordVerify = password_verify($password, $user['password']);

        if ($user) {
            if ($passwordVerify) {
                $sessionData = [
                    'user_id' => $user['user_id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role'  => $user['role'],
                    'logged_in' => true
                ];
                $session->set($sessionData);

                if ($user['role'] === 'admin') {
                    return redirect()->to('/home');
                } elseif ($user['role'] === 'customer') {
                    return redirect()->to('/');
                }
            } else {
                $session->setFlashdata('error', 'Email atau password salah!');
                return redirect()->back();
            }
        }
    }

    public function showRegister()
    {
        $title = 'Register';
        return view('auth/register', compact('title'));
    }

    public function register()
    {
        $session = session();
        $model = new User();

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $checkDuplicateEmail = $model->where('email', $email)->first();

        if (!$checkDuplicateEmail) {
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role'  => 'customer'
            ];

            if ($model->insert($data)) {
                $session->setFlashdata('success', 'Berhasil mendaftar. Anda sekarang dapat login.');
                return redirect()->to('/login');
            } else {
                $session->setFlashdata('error', 'Registrasi akun gagal. Mohon coba lagi.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Registrasi akun gagal. Email sudah digunakan.');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
