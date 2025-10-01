<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman depan
$routes->get('/', 'Dashboard::index');

// Auth
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

// Forbidden
$routes->get('/forbidden', 'Errors::forbidden');

// ADMIN routes
$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::admin');
    $routes->get('anggota', 'Admin\Anggota::index');
    $routes->get('anggota/new',    'Admin\Anggota::create'); 
    $routes->post('anggota',       'Admin\Anggota::store');  
});

// USER routes
$routes->group('user', ['filter' => 'role:user'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::user');
});
