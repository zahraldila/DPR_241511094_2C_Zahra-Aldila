<?php

namespace Config;

use CodeIgniter\Routing\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

// Default
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // lebih aman manual daftarin route

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// --- Auth ---
$routes->get('/',  'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// --- Dashboard ---
$routes->get('dashboard',        'Dashboard::index');
$routes->get('admin/dashboard',  'Dashboard::admin', ['filter' => 'role:admin']);
$routes->get('user/dashboard',   'Dashboard::user',  ['filter' => 'role:user']);

// --- Anggota ---
// Read publik (read-only). Tambahkan ['filter'=>'auth'] kalau harus login dulu.
$routes->get('anggota', 'Anggota::index');

// Admin (CRUD) – semuanya tetap diarahkan ke controller Anggota yang sama
$routes->get('admin/anggota',                 'Anggota::index',  ['filter' => 'role:admin']);
$routes->get('admin/anggota/create',          'Anggota::create', ['filter' => 'role:admin']);
$routes->post('admin/anggota/store',          'Anggota::store',  ['filter' => 'role:admin']);
$routes->get('admin/anggota/edit/(:num)',     'Anggota::edit/$1',   ['filter' => 'role:admin']);
$routes->post('admin/anggota/update/(:num)',  'Anggota::update/$1', ['filter' => 'role:admin']);
$routes->get('admin/anggota/delete/(:num)',   'Anggota::delete/$1', ['filter' => 'role:admin']);
$routes->post('admin/anggota/delete/(:num)',  'Anggota::destroy/$1', ['filter' => 'role:admin']);

// Komponen Gaji (Admin)
$routes->get('admin/komponen',        'Komponen::index', ['filter'=>'role:admin']);
$routes->get('admin/komponen/create', 'Komponen::create', ['filter'=>'role:admin']);
$routes->post('admin/komponen/store', 'Komponen::store',  ['filter'=>'role:admin']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * Environment-based routes
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
