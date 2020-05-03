<?php

namespace app\_\components;

use app\_\base\BaseComponent;

/**
 * Class Library
 * @package app\_\components
 */
class Library extends BaseComponent
{
    //...
    private $library = [];

    /**
     * Library constructor.
     * @param $library
     */
    function __construct( $library )
    {
        parent::__construct([]);

        $this->library = $library;
    }

    /**
     * @param $key string
     * @param $value mixed
     */
    public function set( $key, $value )
    {
        $this->library[ $key ] = $value;
    }

    /**
     * @param $key string
     * @param $default mixed
     * @return mixed
     */
    public function get( $key, $default = null )
    {
        return ( $this->_isset( $key ) ) ? $this->library[ $key ] : $default;
    }

    /**
     * @param $key
     * @return bool
     */
    public function _isset( $key )
    {
        return isset( $this->library[ $key ] );
    }
}