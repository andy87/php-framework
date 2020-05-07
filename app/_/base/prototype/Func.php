<?php

namespace _\base\prototype;

use _\App;
use _\components\Runtime;
use Exception;

/**
 * Trait Func
 * @package app\_
 */
trait Func
{
    /**
     * @param $obj
     * @param bool $exit
     */
    public static function printPre( $obj, $exit = true )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        if ( is_string( $obj ) ) $obj = [$obj];

        echo '<pre>';
        print_r( $obj );
        echo '</pre>';

        if ( $exit ) exit();
    }

    /**
     * @param $str
     * @return string|string[]
     */
    public static function slashReplace( $str )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $form   = [ SLASHER, '\\', '//' ];

        return str_replace( $form, SLASH, $str );
    }

    /**
     *      Форматирование строки в snake Case
     *
     * @param $str
     * @return string
     */
    public static function normalizeName( $str )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        if ( strpos( $str, '-' ) !== false )
        {
           $str = explode( '-', $str );

           foreach ( $str as $index => $item )
           {
               $str[ $index ] = self::ucFirst( $item );
           }

           $resp = implode( '', $str );

        } else {

            $resp = self::ucFirst( $str );
        }

        return $resp;
    }

    /**
     *      Форматирование строки в kebab Case
     *
     * @param $str
     * @return string
     */
    public static function kebabCase( $str )
    {
        if ( ctype_lower( $str ) ) return $str;

        $replacement    = ucwords( str_replace( '_','-', $str ) );

        $str            = preg_replace('/[\s]+/u', '', $replacement );

        return  mb_strtolower( preg_replace('/(.)(?=[A-Z])/u', '$1-', $str ), 'UTF-8');
    }

    /**
     *      Форматирование строки в текст с заглавной буквой
     *
     * @param $str
     * @return string
     */
    public static function  ucFirst( $str )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return ucfirst( strtolower( $str ) );
    }


    /**
     *      Генерация хеша
     *
     * @param string $key
     * @return string
     */
    public function generateHash( $key )
    {
        return md5( CACHE_SALT . $key . App::$request->method . md5( $_REQUEST ) );
    }

    /**
     * @param $str string
     */
    public function test( $str )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        if ( is_bool( $str ) ) $str = ( $str ) ? 'Y' : 'N';
        if ( is_string( $str ) AND empty( $str ) ) $str = 'string( empty )';

        exit( $str );
    }

    /**
     * @param $path string
     * @param $params array
     * @return string
     */
    public function renderFile( $path, $params )
    {
        $resp = '';

        extract( $params );

        try {

            ob_start();

            require $path;

            $resp = ob_get_contents();

            ob_end_clean();

        } catch ( Exception $e ){

            $this->exceptionCatch( $e );
        }

        return $resp;
    }

    /**
     * @param $e Exception
     */
    public function exceptionCatch( $e )
    {
        $this->exception( [
            'error'         => $e->getCode(),
            'message'       => $e->getMessage(),
        ] );
    }
}