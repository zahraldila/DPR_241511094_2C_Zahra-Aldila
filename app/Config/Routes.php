<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('test', 'Test::display');
$routes->get('/', 'Dashboard::index'); // bisa redirect ke login kalau belum login
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

$routes->get('/forbidden', 'Errors::forbidden');

// Group admin
$routes->group('admin', ['filter' => 'role:admin'], static function($routes){
    $routes->get('dashboard', 'Dashboard::admin');
});

// Group user
$routes->group('user', ['filter' => 'role:user'], static function($routes){
    $routes->get('dashboard', 'Dashboard::user');
});

// Jika ingin semua halaman setelah login wajib autentik:
$routes->group('', ['filter' => 'auth'], static function($routes){
    // contoh rute CRUD nantinya
});

