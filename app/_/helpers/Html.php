<?php

namespace _\helpers;

use _\components\Component;

class Html extends Component
{
    /** @var array список одиночных тегов */
    static $singleTags = ['br','hr','meta','img', 'input'];

    /**
     *      Конструктор тегов
     *
     * @param string|array $name
     * @param string|array $content
     * @param array $attributes
     * @return string
     */
    public static function tag( $name = '', $content = '', $attributes = [] )
    {
        if ( is_array( $name ) ) extract( $name );

        $name = strtolower( $name );

        $html = "<$name";

        if ( !empty( $attributes ) )
        {
            foreach ( $attributes as $key => $value )
            {
                $html .= ( ( $value === null ) ? " {$key}" : " {$key}='{$value}'" );
            }
        }
        $html .= '>';

        if ( $content )
        {
            if ( is_string( $content ) ) $html .= $content;

            if ( is_array( $content ) )
            {
                $content = array_merge([
                    'name'          => 'div',
                    'content'       => $content,
                    'attributes'    => []
                ], $content );

                $html .= self::tag( $content );
            }
        }

        if ( ! in_array( $name, self::$singleTags ) )
        {
            $html .= "</{$name}>";
        }

        return $html;
    }

    /**
     * @param string $href
     * @param string $type
     * @param string $rel
     * @return string
     */
    public static function link( $href = '', $type = 'text/css', $rel = 'stylesheet' )
    {
        return "<link type='{$type}' rel='{$rel}' href='{$href}'>";
    }

    /**
     * @param $src
     * @param string $type
     * @return string
     */
    public static function script( $src, $type = 'text/JavaScript' )
    {
        return "<script type='text/javascript' src='{$src}'></script>";
    }

    /**
     * @param $src
     * @param string $class
     * @param string $alt
     * @param string $title
     * @return string
     */
    public static function img( $src, $class = '', $alt = '', $title = '' )
    {
        if ( empty( $alt ) ) $alt = 'картинка';
        if ( empty( $title ) ) $title = $alt;
        if ( !empty( $class ) ) $class = " class='{$class}'";

        return "<img{$class} src='{$src}' alt='{$alt}' title='{$title}'>";
    }

    /**
     * @param string|array $data
     * @return string
     */
    public static function meta( $data )
    {
        return( is_array( $data ) )
            ? self::tag( 'meta', '', $data )
            : "<meta {$data}>";
    }
}
