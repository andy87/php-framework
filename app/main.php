<?php

use _\App;

define('ERROR_LEVEL' , E_ALL & ~E_NOTICE );
error_reporting( ERROR_LEVEL );

require "_/setups/init.php";
require "config/params.php";

if ( params('request.session') ) session_start();

( $app = new App( $params ) )->init();

App::display();