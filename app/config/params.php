<?php

require "setup.php";
require "routes.php";

$params = [

    'title'         => 'My Applications',

    'alias'         => [
        'config'            => __DIR__
    ],

    'request'       => [
        'methods'           => METHOD_LIST,
    ],

    'response'      => [
        'format'           => DEFAULT_RESPONSE,
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