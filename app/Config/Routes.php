<?php

use Config\Services;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes = Services::routes();

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login', ['filter' => 'redirect']);
$routes->get('logout', 'AuthController::logout');


$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('produkkategori', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukKategoriController::index');
    $routes->post('', 'ProdukKategoriController::create');
    $routes->post('edit/(:any)', 'ProdukKategoriController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukKategoriController::delete/$1');
});


// Routes Diskon
$routes->group('diskon', ['filter' => 'role:admin'], function($routes) {
    $routes->get('/', 'DiskonController::index');
    $routes->get('create', 'DiskonController::create');
    $routes->post('store', 'DiskonController::store');
    $routes->get('edit/(:num)', 'DiskonController::edit/$1');
    $routes->post('update/(:num)', 'DiskonController::update/$1');
    $routes->get('delete/(:num)', 'DiskonController::delete/$1');
});


// $routes->get('diskon', 'DiskonController::index', ['filter' => 'auth']);

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);

$routes->get('profile', 'Home::profile', ['filter' => 'auth']);
$routes->get('contact', 'ContactController::index', ['filter' => 'auth']);

// routes api
$routes->resource('api', ['controller' => 'apiController']);