<?php

define('DOG', '@');
define('PHP', ".php");
define('SLASH', '/');
define('SLASHER', '\\');


define('SRC_JQUERY', "//code.jquery.com/jquery-3.5.0.js");
define('SRC_JQUERY_MIN', "//code.jquery.com/jquery-3.5.0.min.js");

define('DEFAULT_CONTROLLER', "site");
define('DEFAULT_ACTION', "index");
define('DEFAULT_RESPONSE', "text/html");
define('DEFAULT_CHARSET', "utf-8");
define('DEFAULT_LANG', "ru");
define('DEFAULT_CODE', 200);


define('CONTROLLER_SUFFIX', "Controller");
define('CONTROLLER_NAMESPACE', "app\\controllers\\");

define('ACTION_PREFIX', "action");
define('ACTION_ERROR', "error");


define('TEMPLATE_ERROR', '@root/app/_/templates/error' . PHP );
define('TEMPLATE_FORMAT', PHP );

define('AJAX', "XMLHttpRequest");

define('METHOD_LIST', ['POST','GET','PUT','UPDATE','DELETE','HEAD','CONNECT','OPTIONS','TRACE','PATCH' ]);

define('DIRECTORY_APP', ['config','controllers','models','static','views']);
define('DIRECTORY_STATIC', ['css','js', 'img', 'docs', 'fonts']);