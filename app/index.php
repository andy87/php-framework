<?php

use \app\_\App;

$root = str_replace('\app', '', __DIR__);

require "_/setups/autoload.php";
require "config/params.php";

( $app = new App( $params ) )->init();

echo App::$response->getContent();
