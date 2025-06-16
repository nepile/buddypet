<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', "CustomerController::showHomeCustomer");
$routes->get('/product-detail/(:any)', "CustomerController::showDetailProduct/$1")
;
$routes->get('/cart', "CartController::showCart");
$routes->post('/add-to-cart', "CartController::addToCart");
$routes->post('/cart/update', 'CartController::updateCart');
$routes->get('/cart/remove/(:segment)', 'CartController::removeFromCart/$1');
$routes->post('/cart/checkout', 'CartController::checkout');

$routes->get('/orders', "OrderController::viewOrders");
$routes->post('/create-order', "OrderController::createOrder");
$routes->get('/order-detail/(:any)', "OrderController::viewOrderDetail/$1");
$routes->get('/order-history', "OrderController::viewOrderHistory");

$routes->get('/payment', "PaymentController::showPaymentPage");
$routes->post('/payment/confirm', "PaymentController::confirmPayment");

$routes->get('/transactions', "TransactionController::index");
$routes->post('/transactions/delete/(:any)', "TransactionController::delete/$1");

$routes->get('/login', 'AuthController::showLogin');
$routes->post('/handle-login', 'AuthController::login');
$routes->get('/register', 'AuthController::showRegister');
$routes->post('/handle-register', 'AuthController::register');
$routes->post('/handle-logout', 'AuthController::logout');

$routes->get('/product-management', 'ProductController::showProductManagement');
$routes->post('/product-store', 'ProductController::store');
$routes->put('/product-update/(:any)', 'ProductController::update/$1');
$routes->post('/product-delete/(:any)', 'ProductController::delete/$1');
