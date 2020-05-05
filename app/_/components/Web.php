<?php

namespace app\_\components;

use app\_\App;
use app\_\base\Core;

/**
 * Class Web
 * @package app\_\components
 */
class Web extends Core
{
    /** @var null|string ID фактически вызываемого Controller|Action */
    public $id = '';

    /** @var string Имя вызываемого объекта */
    public $target = '';

    /** @var string ID вызываемого по умолчанию Controller|Action */
    public $default = '';

    /** @var bool Статус существования */
    public $exists  = false;

    /**
     * Web constructor.
     * @param $params
     */
    function __construct( $params )
    {
        parent::__construct( $params );

        $this->setId( $this->getClassName(true) );

        $this->init();
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