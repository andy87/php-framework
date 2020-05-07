<?php

use _\App;

// Устанавливаем уровень обработки ошибок
define('ERROR_LEVEL' , E_ALL & ~E_NOTICE );
error_reporting( ERROR_LEVEL );

require "_/setups/init.php";
require "config/params.php";

( $app = new App( $params ) )->init();

App::display();