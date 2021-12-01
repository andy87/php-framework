<?php

/**
 *      Автозагрузка классов
 */
spl_autoload_register( function( $class )
{
    $classPath = DOCUMENT_ROOT . "\\app\\$class" . PHP;

    if ( file_exists( $classPath ) )
    {
        require_once $classPath;

    } else {

        Exit("Scary error! File not found: {$classPath}");
    }
});

/**
 *      Занрузка конфига "приватных реквизитов"
 */
function setups()
{
    return require DIR_SETUPS . SETUPS . PHP;
}

/**
 *      получение данных из параметров
 *
 * @param $key
 * @param array $arr
 * @return array
 */
function params($key, array $arr = [])
{
    $resp  = ( $arr ) ? $arr : $GLOBALS['params'];

    $path = ( strpos( $key, DOT) !== false )
        ? explode(DOT, $key )
        : [ $key ];

    foreach ( $path as $value )
    {
        $resp = ( $resp AND isset( $resp[ $value ]) )
            ? $resp[ $value ]
            : null;
    }

    return $resp;
}