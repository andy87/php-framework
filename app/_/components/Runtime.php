<?php

namespace app\_\components;

use app\_\App;

/**
 * Class Runtime
 * @package app\_\components
 */
class Runtime extends Core
{
    /** @var string Список вызванных функций */
    static $path = '/app/_/runtime/logs/app.log';

    /** @var bool  */
    static $fileExists = false;

    /**
     * Runtime constructor.
     * @param $params
     */
    function __construct( $params )
    {
        parent::__construct( $params );
    }

    /**
     * @param $class
     * @param $method
     * @param $line
     */
    public static function log( $class, $method, $line )
    {
        if ( !self::$fileExists )
        {
            self::$path = $_SERVER['DOCUMENT_ROOT'] . self::$path;

            fopen( self::$path, "a+" );

            self::$fileExists = file_exists(self::$path);
        }

        if ( self::$fileExists )
        {
            $log = fopen( self::$path, "a+");

            if ( $log )
            {
                $method = array_pop( explode('::', $method ) );
                $class  = array_pop( explode('\\', $class ) );
                $row    = implode('; ', [ date("d.m.Y H:i:s"), $line, $class, $method ]) . "\r\n";

                fwrite($log, $row );

                fclose($log);
            }
        }
    }

    public static function  load(){

        //TODO: выгрузка в app/_/runtime/log.log
    }
}