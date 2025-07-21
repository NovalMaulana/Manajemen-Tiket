<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Test Routes
$routes->get('test', 'Test::index');
$routes->get('test/login', 'Test::login');
$routes->post('test/login', 'Test::login');

// Auth Routes
$routes->get('/', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register', 'Auth::register');
$routes->get('auth/logout', 'Auth::logout');

// Routes yang memerlukan autentikasi
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    
    // Routes untuk admin
    $routes->group('', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('users', 'Users::index');
        $routes->get('users/create', 'Users::create');
        $routes->post('users/store', 'Users::store');
        $routes->get('users/edit/(:num)', 'Users::edit/$1');
        $routes->post('users/update/(:num)', 'Users::update/$1');
        $routes->get('users/delete/(:num)', 'Users::delete/$1');
    });
    
    // Routes untuk admin dan event organizer
    $routes->group('', ['filter' => 'auth:admin,event_organizer'], function($routes) {
        $routes->get('events', 'Events::index');
        $routes->get('events/create', 'Events::create');
        $routes->post('events/store', 'Events::store');
        $routes->get('events/view/(:num)', 'Events::view/$1');
        $routes->get('events/edit/(:num)', 'Events::edit/$1');
        $routes->post('events/update/(:num)', 'Events::update/$1');
        $routes->get('events/delete/(:num)', 'Events::delete/$1');
    });
    
    // Route untuk tiket terjual (admin dan organizer)
    $routes->get('tickets/sold-tickets', 'Tickets::soldTickets', ['filter' => 'auth']);
    
    // Routes untuk customer
    $routes->group('', ['filter' => 'auth:customer'], function($routes) {
        $routes->get('tickets/my-tickets', 'Tickets::myTickets');
        $routes->get('tickets/buy/(:num)', 'Tickets::buy/$1');
        $routes->post('tickets/purchase/(:num)', 'Tickets::purchase/$1');
    });
    
    // Route untuk beli tiket (semua user yang login)
    $routes->get('tickets/buy/(:num)', 'Tickets::buy/$1', ['filter' => 'auth']);
    $routes->post('tickets/purchase/(:num)', 'Tickets::purchase/$1', ['filter' => 'auth']);
    $routes->get('tickets/my-tickets', 'Tickets::myTickets', ['filter' => 'auth']);
    $routes->post('tickets/mark-as-paid', 'Tickets::markAsPaid', ['filter' => 'auth']);
    
    // Routes untuk profile (semua user yang login)
    $routes->get('profile', 'Profile::index');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
    $routes->get('profile/change-password', 'Profile::changePassword');
    $routes->post('profile/update-password', 'Profile::updatePassword');
});