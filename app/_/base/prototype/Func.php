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
     *      Обработка путей (замена слешей)
     *
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
     *      Форматирование строки в CamelCase
     *
     * @param string $str
     * @return string
     */
    public static function setupCamelCase( $str )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $str    = str_replace(['-','_'],['_', SLASH], $str );

        $data   = explode( SLASH, $str );

        $data = array_map(function ( $str )
        {
            return ucfirst( strtolower($str) );

        }, $data );

        $str = implode('', $data );

        return $str;
    }

    /**
     *      Форматирование строки в snake_case
     *
     * @param string $str
     * @return string
     */
    public static function setupSnakeCase( $str )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $str = self::setupCase( $str, '$1_' );

        $str = str_replace(['-','--','__'],'_', $str );

        return  $str;
    }

    /**
     *      Форматирование строки в kebab-kase
     *
     * @param string $str
     * @return string
     */
    public static function setupKebabCase( $str )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $str = self::setupCase( $str, '$1-' );

        $str = str_replace(['_','__','--'],'-', $str );

        return  $str;
    }

    /**
     *      Общий метод для snake & cebab
     *
     * @param $str
     * @param $to
     * @return string
     */
    public static function setupCase( $str, $to )
    {
        if ( ctype_lower( $str ) ) return $str;

        $replacement    = ucwords( str_replace( '_','-', $str ) );

        $str            = preg_replace('/[\s]+/u', '', $replacement );

        return  mb_strtolower( preg_replace('/(.)(?=[A-Z])/u', $to, $str ), 'UTF-8');

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
     *      Ядро рендера
     *
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
     *      Вызов исключения Catch
     *
     * @param $e Exception
     */
    public function exceptionCatch( $e )
    {
        $this->exception([
            'error'         => $e->getCode(),
            'message'       => $e->getMessage(),
        ]);
    }

    /**
     *      Выводд строки с завершением работы скриптов
     *
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
     *      Выводд массива с завершением работы скриптов
     *
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

}