<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', "CustomerController::showHomeCustomer");

$routes->get('/login', 'AuthController::showLogin');
$routes->post('/handle-login', 'AuthController::login');
$routes->get('/register', 'AuthController::showRegister');
$routes->post('/handle-register', 'AuthController::register');
$routes->post('/handle-logout', 'AuthController::logout');

$routes->get('/home', function () {
    return view('admin/home');
});
