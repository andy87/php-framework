<?php

require "setup.php";
require "routes.php";

$params = [

    'title'         => 'My Applications',

    'charset'       => DEFAULT_CHARSET,

    'debug'         => 3, // 0/1/2/3

    'alias'         => [
        '@root'          => $_SERVER['DOCUMENT_ROOT']
    ],

    'request'       => [
        'methods'           => METHOD_LIST,
        'runtime'           => false
    ],

    'response'      => [
        'format'            => DEFAULT_RESPONSE,
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

    'setups'        => $setup,

    'routes'        => $routes,
];