<?php
    $routes = array(
        'Httpstatus' => [
            'home' => '/',
            'login' => '/login',
            'admin' => '/admin',
            'add' => '/admin/add',
            'edit' => '/admin/edit/{id}',
            'show' => '/show/{id}'
        ]
    );

    define('ROUTES', $routes);
