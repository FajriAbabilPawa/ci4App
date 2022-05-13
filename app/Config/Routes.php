<?php

namespace Config;

use App\Controllers\users;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// $routes->set404Override(function () {
//     $data = ['title' => '404 Not Found'];
//     return view('errors/http/404_not-found', $data);
// }); // Custom 404
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//...

$routes->match(['get', 'post'], 'register', 'UserController::register', ['filter' => 'noauth']);
$routes->match(['get', 'post'], 'login', 'UserController::login', ["filter" => "noauth"]);

$routes->get('/', 'Home::index');
$routes->get('/login', 'User::login', ['filter'=>'notLogged']);
$routes->get('/register', 'User::register', ['filter'=>'notLogged']);
$routes->post('/userRegister', 'User::userRegister');
$routes->post('/userLogin', 'User::userLogin');
$routes->get('profile', 'users::profile');
$routes->get('/logout', 'Usercontroller::logout', ['filter'=>'auth']);
$routes->match(['get', 'post'], '/updateprofile', 'users::profileupdate', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/profileupdate', 'users::profileupdate', ['filter' => 'auth']);
$routes->get('/changepassword', 'users::changepassword', ['filter'=>'auth']);
$routes->post('/updatepassword', 'users::updatepassword', ['filter'=>'auth']);
$routes->get('/deleteAccount', 'users::deleteAccount', ['filter'=>'auth']);

// Admin routes
$routes->group("admin", ["filter" => "auth"], function ($routes) {
    $routes->get("/", "AdminController::index");
});
// Member routes
$routes->group("member", ["filter" => "auth"], function ($routes) {
    $routes->get("/", "MemberController::index");
});
$routes->get('logout', 'UserController::logout');

//Simpan Data Mahasiswa
$routes->post('/mahasiswa/SimpanData', 'Mahasiswa::SimpanData');
//Edit Data Mahasiswa
$routes->add('/mahasiswa/edit/(:any)', 'Mahasiswa::edit/$1');
// Hapus Data Mahasiswa
$routes->get('/mahasiswa/hapus/(:segment)', 'Mahasiswa::hapus/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
