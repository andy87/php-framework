<?php

namespace app\_\components;

use app\_\App;
use app\_\base\BaseComponent;

/**
 * Class Web
 * @package app\_\components
 */
class Web extends BaseComponent
{
    /** @var null|string  */
    public $id = null;

    /** @var string */
    public $default = '';

    /**
     * Web constructor.
     * @param $params
     */
    function __construct( $params )
    {
        parent::__construct( $params );

        $this->setId( $this->getClassName(true) );
    }

    /**
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @param $type string [ controller|action ]
     */
    public function  setId( $type )
    {
        $this->id = $this->default;

        if ( !empty(App::$route->{$type}) )
        {
            $this->id = $this->normalizeName( App::$route->{$type} );
        }
    }
}