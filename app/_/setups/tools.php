<?php

spl_autoload_register( function( $class )
{
    $classPath = DOCUMENT_ROOT . "\\app\\$class" . PHP;

    if ( file_exists( $classPath ) )
    {
        require_once $classPath;
    }
});

/**
 *
 */
function setups()
{
    require_once PATH_SETUPS . HOST . PHP;
}

/**
 * @param $key
 * @param array $arr
 * @return array
 */
function params( $key, $arr = [] )
{
    $resp  = ( $arr ) ? $arr : $GLOBALS['params'];

    $path = ( strpos( $key, DOT) !== false )
        ? explode(DOT, $key )
        : [ $key ];

    foreach ( $path as $value )
    {
        $resp = ( $resp AND isset( $resp[ $value ] ) )
            ? $resp[ $value ]
            : null;
    }

    return $resp;
}