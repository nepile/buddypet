<?php
namespace App\Controllers;
use App\Models\User;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        $session = session();
        $model = new User();

        if ($this->request->getMethod() == 'post') {
            $password = $this->request->getPost('password');
            $email = $this->request->getPost('email');

            $user = $model->where('email', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                $sessionData = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],

                    'logged_in' => true
                ];
                $session->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Invalid username or password');
            }
        }

        return view('auth/login');
    }

    public function register()
    {
        $session = session();
        $model = new User();

        if ($this->request->getMethod() == 'post') {
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ];

            if ($model->insert($data)) {
                $session->setFlashdata('success', 'Registration successful. You can now log in.');
                return redirect()->to('/login');
            } else {
                $session->setFlashdata('error', 'Registration failed. Please try again.');
            }
        }

        return view('auth/register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}