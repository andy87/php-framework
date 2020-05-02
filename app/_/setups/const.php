<?php

define('DOG', "@");
define('PHP', ".php");
define('SLASH', '/');
define('SLASHER', '\\');

define('DEFAULT_CONTROLLER', "site");
define('DEFAULT_ACTION', "index");
define('DEFAULT_RESPONSE', "text/html");

define('CONTROLLER_SUFFIX', "Controller");
define('CONTROLLER_NAMESPACE', "app\\controllers\\");

define('ACTION_PREFIX', "action");
define('ACTION_ERROR', "error");

define('TEMPLATE_ERROR', 'app/_/template/error' . PHP );

define('AJAX', "XMLHttpRequest");

define('METHOD_LIST', ['POST','GET','PUT','UPDATE','DELETE','HEAD','CONNECT','OPTIONS','TRACE','PATCH' ]);

define('DIRECTORY_LIST', ['config','controllers','models','views','static']);