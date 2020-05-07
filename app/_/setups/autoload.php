<?php

require "const.php";

spl_autoload_register( function( $class )
{
    $classPath = "{$GLOBALS['root']}\\app\\$class" . PHP;

    if ( file_exists( $classPath ) )
    {
        require_once $classPath;
    }
} );