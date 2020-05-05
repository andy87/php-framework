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
    /** @var bool Статус активности модуля */
    static $status = false;
    
    /** @var string Список вызванных функций */
    static $path = '/app/_/runtime/logs/app.log';

    /** @var bool признак существования файла app.log */
    static $fileExists = false;

    /** @var array список меток  */
    static $log = [];

    /**
     * @param $class
     * @param $method
     * @param $line
     */
    public static function log( $class, $method, $line )
    {
        if ( !self::$status ) return;

        $method = array_pop( explode('::', $method ) );
        $class  = array_pop( explode('\\', $class ) );

        self::$log[] = implode('; ', [ self::time(), $line, "$class::$method()" ]) . RN;
    }

    /**
     *      Заполнение файла app.log данными
     */
    public static function  push()
    {
        if ( !self::$fileExists )
        {
            self::$path = $_SERVER['DOCUMENT_ROOT'] . self::$path;

            self::getFileHandler();

            self::$fileExists = file_exists( self::$path );
        }

        if ( self::$fileExists )
        {
            if ( $fileLog = self::getFileHandler() )
            {
                $firstLogRow = RN .RN . self::time() . ' ' . App::$request->method . ' | ' . App::$request->uri . RN;

                fwrite( $fileLog, $firstLogRow );

                foreach ( self::$log as $log ) fwrite( $fileLog, $log );

                fclose($fileLog);
            }
        }
    }

    /**
     * @return false|resource
     */
    private static function getFileHandler()
    {
        return fopen( self::$path, "a+");
    }

    /**
     *      Временная метка в логах
     *
     * @param string $format
     * @return false|string
     */
    private static function time( $format = "d.m.Y H:i:s" )
    {
        return date( $format );
    }
}