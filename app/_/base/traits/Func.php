<?php

namespace app\_\base\traits;

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
        return str_replace(SLASHER, SLASH, $str );
    }

    /**
     * @param $str
     * @return string
     */
    public static function normalizeName( $str )
    {
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
        return ucfirst( strtolower( $str ) );
    }

    /**
     * @param $str string
     */
    public function test( $str )
    {
        if ( is_bool($str) ) $str = ( $str ) ? 'Y' : 'N';
        if ( is_string($str) AND empty($str) ) $str = 'string(empty)';

        exit( $str );
    }
}