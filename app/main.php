<?php

use _\App;

require '_/setups/init.php';
require 'config/routes.php';
require 'config/params.php';

error_reporting( ERROR_LEVEL );

if ( params('request.session') ) session_start();

( $app = new App( $params ) )->init();

App::display();