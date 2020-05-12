<?php

$routes = [

    // URI( url )             Controller/action
    '/'                                 => 'site/index',
    'sign-up'                           => 'site/sign-up',
    'index'                             => 'site/index',
    'login'                             => 'site/login',
    'test'                              => 'site/test',
    'contact'                           => 'site/contact',
    'gradient-color'                    => 'color-gradient/linear-gradient',
    'gradient-color/json'               => 'color-gradient/return-json',
    'gradient-color/json2'              => 'color-gradient/return-json2',
    'gradient-color/2'                  => 'color-gradient/radial-gradient',

    //TODO: сделать возможность аргументов в URI !!!!!!!!!!!!!!!!!!!!!!!!
    //profile/username/admin                => 'profile/by-user-name',  // actionByUserName( 'admin' )
    'profile/username/<userName:[\w\d]>'    => 'profile/by-user-name',  // actionByUserName( $userName )
    //profile/id/777                        => 'profile/by-id',         // actionById( 777 )
    'profile/user-id/<id:[\d]>'             => 'profile/by-id',         // actionById( $id )

    'profile/action/<userName:[\w\d]>/<id:[\d]>/<action:[\w]>'      => 'profile/by-user-name',  // actionByUserName( $userName )
    'profile/<action>/action/<userName:[\w\d]>/<id:[\d]>'           => 'profile/<action>',  // actionByUserName( $userName )

    'gradient-color/<action>'           => 'color-gradient/<action>',

    'post'                              => 'post/index',
    'post/<action>'                     => 'post/<action>',

    '<action>/<controller>'             => '<controller>/<action>',
    '<controller>/<action>'             => '<controller>/<action>',

    '<controller>'                      => '<controller>/index',
];