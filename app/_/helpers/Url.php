<?php

namespace _\helpers;

use _\App;
use _\components\Component;

/**
 *      Проверяет существование файла
 *
 * @package app\_\helpers
 */
class Url extends Component
{
    /** @var array отовый шаблон ошибки */
    public static $error = [
        'error'     => "File `path` not found",
        'message'   => "File not found",
    ];


    /**
     * @param string $uri
     * @return mixed
     */
    public static function css( $uri )
    {
        $path = App::getAlias( "@css/{$uri}" );

        if ( !file_exists( $path ) ) self::exceptionError( $uri );

        return $uri;
    }

    /**
     * @param string $uri
     * @return mixed
     */
    public static function docs( $uri )
    {
        $path = App::getAlias( "@docs/{$uri}" );

        if ( !file_exists( $path ) ) self::exceptionError( $uri );

        return $uri;
    }

    /**
     * @param string $uri
     * @return mixed
     */
    public static function fonts( $uri )
    {
        $path = App::getAlias( "@fonts/{$uri}" );

        if ( !file_exists( $path ) ) self::exceptionError( $uri );

        return $uri;
    }

    /**
     * @param string $uri
     * @return mixed
     */
    public static function img( $uri )
    {
        $path = App::getAlias( "@img/{$uri}" );

        if ( !file_exists( $path ) ) self::exceptionError( $uri );

        return $uri;
    }

    /**
     * @param string $uri
     * @return mixed
     */
    public static function js( $uri )
    {
        $path = App::getAlias( "@js/{$uri}" );

        if ( !file_exists( $path ) ) self::exceptionError( $uri );

        return $uri;
    }


    /**
     * @param string $uri
     */
    public static function exceptionError( $uri )
    {
        self::$error['message'] = str_replace( '`path`', "`{$uri}`", self::$error['message']);
        self::exception( self::$error );
    }
}
