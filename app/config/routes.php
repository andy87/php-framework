<?php

$routes = [
    // URI(url)             Controller/action
    'sign-up'           => 'site/sign-up',
    'login'             => 'site/login',
    'contact'           => 'site/contact',
    'gradient-color'    => 'color-gradient/linear-gradient',
    'gradient-color/2'  => 'color-gradient/radial-gradient',
    //TODO: сделать возможность аргументов в URI
    'gradient-color/<action>' => 'color-gradient/<action>',
    //'gradient-color/<from:[\w\d]>/<to:[\w\d]>' => 'color-gradient/linear-gradient',
    '/'                  => 'site/index',
];