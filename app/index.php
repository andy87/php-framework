<?php

use _\App;

define('ERROR_LEVEL' , E_ALL & ~E_NOTICE );

error_reporting( ERROR_LEVEL );

$root = str_replace( '\app', '', __DIR__ );

require "_/setups/init.php";
require "config/params.php";

( $app = new App( $params ) )->init();

App::display();