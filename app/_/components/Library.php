<?php

namespace _\components;

use _\App;
use _\base\Core;

/**
 * Class Library
 * @package app\_\components
 */
class Library extends Core
{
    //...
    private $library = [];

    /**
     * Library constructor.
     * @param $library
     */
    function __construct( $library )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        parent::__construct( App::$params );

        $this->setLibrary( $library );
    }

    /**
     *      Задаём библиотеку
     *
     * @param $data
     */
    public function setLibrary( $data )
    {
        $this->library = $data;
    }

    /**
     * @param $key string
     * @param $value mixed
     */
    public function set( $key, $value )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $this->library[ $key ] = $value;
    }

    /**
     * @param $key string
     * @param $default mixed
     * @return mixed
     */
    public function get( $key, $default = null )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return ( $this->_isset( $key ) ) ? $this->library[ $key ] : $default;
    }

    /**
     * @param $key
     * @return bool
     */
    public function _isset( $key )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return isset( $this->library[ $key ] );
    }
}