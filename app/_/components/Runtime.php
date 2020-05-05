<?php

namespace app\_\components;

use app\_\App;
use app\_\base\Core;

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

    /** @var array записи */
    static $log = [];

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
        self::$log[] = implode('; ', [ date("d.m.Y H:i:s"), $line, "$class::$method()" ]) . RN;
    }

    /**
     *
     */
    public static function  load()
    {
        if ( !self::$fileExists )
        {
            self::$path = $_SERVER['DOCUMENT_ROOT'] . self::$path;

            fopen( self::$path, "a+" );

            self::$fileExists = file_exists(self::$path);
        }

        if ( self::$fileExists )
        {
            $fileLog = fopen( self::$path, "a+");


            if ( $fileLog )
            {
                $firstLogRow = RN .RN . date("d.m.Y H:i:s") . ' ' . App::$request->method . ' | ' . App::$request->uri . RN;

                fwrite( $fileLog, $firstLogRow );

                foreach ( self::$log as $log )
                {
                    fwrite( $fileLog, $log );
                }

                fclose($fileLog);
            }
        }
    }
}