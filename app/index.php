<?php

use _\App;

session_start();
error_reporting( E_ALL );

$root = str_replace( '\app', '', __DIR__ );

require "_/setups/autoload.php";
require "config/params.php";

( $app = new App( $params ) )->init();

App::display();
