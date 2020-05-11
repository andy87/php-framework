<?php

$params = [

    'title'         => 'My Applications',

    'charset'       => DEFAULT_CHARSET,

    'debug'         => 2, // 0/1/2/3

    'alias'         => [
        '@root'             => DOCUMENT_ROOT
    ],

    'request'       => [
        'methods'           => METHOD_LIST,
        'runtime'           => false,
        'files'             => true,
        'cookie'            => true,
        'session'           => true,
    ],

    'response'      => [
        'format'            => DEFAULT_RESPONSE,
        'runtime'           => true,
        'cache'             => false,
    ],

    'controller'    => [
        'suffix'            => CONTROLLER_SUFFIX,
        'default'           => DEFAULT_CONTROLLER
    ],

    'action'        => [
        'prefix'            => ACTION_PREFIX,
        'default'           => DEFAULT_ACTION,
        'error'             => ACTION_ERROR,
    ],

    'route'         => [
        'rules'             => $routes
    ],

    'view'          => [
        'css'               => [
            '/css/style.css'
        ]
    ],

    'setups'        => setups(),
];