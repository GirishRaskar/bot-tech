<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('first', 'Home::first');

$routes->get('/', 'Home::index');

$routes->post('generate', 'Thoughts\thoughts::onSubmit');

$routes->post('visit-count', 'Thoughts\thoughts::visitCount');
