<?php

namespace _\helpers;

use _\components\Component;
use _\components\Library;
use _\components\Runtime;

/**
 * Class Session
 * @package app\_\components\library
 */
class File extends Component
{
    /**
     *      Генерация контента
     *
     * @param $path
     * @param $params
     * @return false|string
     */
    public static function generateContent( $path, $params )
    {
        $tempalte = file_get_contents( $path );

        $from   = array_keys($params);
        $to     = array_values($params);

        $from = array_map( function( $str )
        {
            return '{{$' . $str . '}}' ;
        }, $from );

        $tempalte = str_replace( $from, $to, $tempalte );

        return $tempalte;
    }

    /**
     *      Генерация контента
     *
     * @param $path
     * @param $content
     * @return bool
     */
    public static  function generateFile( $path, $content )
    {
        $handler = fopen($path, "w");

        fputs( $handler, $content );

        fclose( $handler );

        return file_exists( $path );
    }
}