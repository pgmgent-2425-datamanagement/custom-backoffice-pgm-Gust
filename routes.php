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

$router->get('/authors', 'AuthorController@list');
$router->get('/author/add', 'AuthorController@add');
$router->post('/author/add', 'AuthorController@save');
$router->get('/author/edit/(\d+)', 'AuthorController@edit');
$router->post('/author/edit/(\d+)', 'AuthorController@update');
$router->post('/author/delete/(\d+)', 'AuthorController@delete'); 

$router->get('/api/books', 'ApiBookController@list');
$router->post('/api/comments', 'ApiBookController@addComment'); 