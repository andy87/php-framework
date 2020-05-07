<?php

define('ERROR_LEVEL' , E_ALL & ~E_NOTICE );

define( 'DOG', '@' );
define( 'DOT', '.' );
define( 'PHP', ".php" );
define( 'SLASH', '/' );
define( 'SLASHER', '\\' );
define( 'RN',  "\r\n" );
define( 'CORE',  SLASH . "app" );

define('HOST', ( isset($_SERVER['HTTP_HOST']) ) ? $_SERVER['HTTP_HOST'] : 'localhost');
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

define( 'SRC_JQUERY', "//code.jquery.com/jquery-3.5.0.js" );
define( 'SRC_JQUERY_MIN', "//code.jquery.com/jquery-3.5.0.min.js" );

define( 'DEFAULT_CONTROLLER', "site" );
define( 'DEFAULT_ACTION', "index" );
define( 'DEFAULT_RESPONSE', "text/html" );
define( 'DEFAULT_CHARSET', "utf-8" );
define( 'DEFAULT_LANG', "ru" );
define( 'DEFAULT_CODE', 200 );

define( 'DIR_APP', DOCUMENT_ROOT . CORE );
define( 'DIR_SETUPS', DIR_APP . "/config/setups/");
define( 'DIR_TEMPLATES', DIR_APP . "/_/templates/");

define( 'CONTROLLER_SUFFIX', "Controller" );
define( 'CONTROLLER_NAMESPACE', "controllers\\" );

define( 'ACTION_PREFIX', "action" );
define( 'ACTION_ERROR', "error" );

define( 'TEMPLATE_ERROR', DIR_TEMPLATES . '/error' . PHP );
define( 'TEMPLATE_FORMAT', PHP );

define( 'AJAX', "XMLHttpRequest" );

define( 'CACHE_SALT', "qwerty" );

define( 'METHOD_LIST', ['POST','GET','PUT','UPDATE','DELETE','HEAD','CONNECT','OPTIONS','TRACE','PATCH' ] );

define( 'DIRECTORY_APP', ['config','controllers','models','static','views'] );
define( 'DIRECTORY_STATIC', ['css','js', 'img', 'docs', 'fonts'] );