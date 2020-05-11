<?php

$routes = [

    // URI( url )             Controller/action
    '/'                             => 'site/index',
    'sign-up'                       => 'site/sign-up',
    'index'                         => 'site/index',
    'login'                         => 'site/login',
    'test'                          => 'site/test',
    'contact'                       => 'site/contact',
    'gradient-color'                => 'color-gradient/linear-gradient',
    'gradient-color/json'           => 'color-gradient/return-json',
    'gradient-color/json2'          => 'color-gradient/return-json2',
    'gradient-color/2'              => 'color-gradient/radial-gradient',

    //TODO: сделать возможность аргументов в URI !!!!!!!!!!!!!!!!!!!!!!!!
    'profile/username/<userName:[\w\d]>'  => 'profile/by-user-name',  // actionByUserName( $userName )
    'profile/id/<id:\d>'                  => 'profile/by-id',         // actionById( $id )

    'gradient-color/<action>'       => 'color-gradient/<action>',

    '<action>'                      => 'site/<action>',
    '<controller>/<action>'         => '<controller>/<action>',
];