<?php
    $routes = array(
        'Httpstatus' => [
            'home' => '/',
            'login' => '/login',
            'admin' => '/admin',
            'add' => '/admin/add',
            'edit' => '/admin/edit/{id}',
            'show' => '/show/{id}'
        ],
        'Api' => [
            'home' => '/api/',
            'list' => '/api/list',
            'add' => '/api/add',
            'status' => '/api/status/{id}',
            'history' => '/api/history/{id}',
            'delete' => '/api/delete/{id}'
        ],
    );

    define('ROUTES', $routes);
