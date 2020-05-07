<?php

$routes = [
    // URI( url )             Controller/action
    'sign-up'           => 'site/sign-up',
    'login'             => 'site/login',
    'contact'           => 'site/contact',
    'gradient-color'        => 'color-gradient/linear-gradient',
    'gradient-color/json'   => 'color-gradient/return-json',
    'gradient-color/json2'   => 'color-gradient/return-json2',
    'gradient-color/2'      => 'color-gradient/radial-gradient',
    //TODO: сделать возможность аргументов в URI
    'gradient-color/<action>' => 'color-gradient/<action>',
    //'gradient-color/<from:[\w\d]>/<to:[\w\d]>' => 'color-gradient/linear-gradient',
    '/'                  => 'site/index',
];