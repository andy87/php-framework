<?php

spl_autoload_register( function( $class )
{
    $classPath = "{$_SERVER['DOCUMENT_ROOT']}\\app\\$class" . PHP;

    if ( file_exists( $classPath ) )
    {
        require_once $classPath;
    }
} );