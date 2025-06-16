<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', "CustomerController::showHomeCustomer");
$routes->get('/product-detail/(:any)', "CustomerController::showDetailProduct/$1");


$routes->get('/login', 'AuthController::showLogin');
$routes->post('/handle-login', 'AuthController::login');
$routes->get('/register', 'AuthController::showRegister');
$routes->post('/handle-register', 'AuthController::register');
$routes->post('/handle-logout', 'AuthController::logout');

$routes->get('/home', function () {
    return view('admin/home');
});

$routes->get('/product-management', 'ProductController::index');
$routes->post('/product-store', 'ProductController::store');
$routes->put('/product-update/(:any)', 'ProductController::update/$1');
$routes->delete('/product-delete/(:any)', 'ProductController::delete/$1');
