<?php

// $router->get('/', function() { echo 'Dit is de index vanuit de route'; });
$router->setNamespace('\App\Controllers');
$router->get('/', 'HomeController@index');
$router->get('/books', 'BookController@list');
$router->get('/book/(\d+)', 'BookController@detail');
$router->get('/book/add', 'BookController@add');
$router->post('/book/add', 'BookController@save');

$router->post('/book/delete/(\d+)', 'BookController@delete');
$router->get('/book/edit/(\d+)', 'BookController@edit'); 
$router->post('/book/update/(\d+)', 'BookController@update'); 