<?php

namespace app\_\base\prototype;

use app\_\components\Runtime;

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
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( is_string($obj) ) $obj = [$obj];

        echo '<pre>';
        print_r($obj);
        echo '</pre>';

        if ( $exit ) exit();
    }

    /**
     * @param $str
     * @return string|string[]
     */
    public static function slashReplace( $str )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        return str_replace(SLASHER, SLASH, $str );
    }

    /**
     * @param $str
     * @return string
     */
    public static function normalizeName( $str )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( strpos($str, '-') !== false )
        {
           $str = explode( '-', $str );

           foreach ( $str as $index => $item )
           {
               $str[ $index ] = self::ucFirst( $item );
           }

           $resp = implode('', $str );

        } else {

            $resp = self::ucFirst( $str );
        }

        return $resp;
    }

    /**
     * @param $str
     * @return string
     */
    public static function  ucFirst( $str )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        return ucfirst( strtolower( $str ) );
    }

    /**
     * @param $str string
     */
    public function test( $str )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( is_bool($str) ) $str = ( $str ) ? 'Y' : 'N';
        if ( is_string($str) AND empty($str) ) $str = 'string(empty)';

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

        try {

            extract($params);

            ob_start();

            require_once $path;

            $resp = ob_get_contents();

            ob_end_clean();

        } catch ( \Exception $e ) {

            $this->exceptionCatch( $e );
        }

        return $resp;
    }

    /**
     * @param $e \Exception
     * @return array
     */
    public function exceptionCatch( $e )
    {
        $this->exception( [
            'error'         => $e->getCode(),
            'message'       => $e->getMessage(),
        ]);
    }
}