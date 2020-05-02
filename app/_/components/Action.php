<?php

namespace app\_\components;

use app\_\App;

/**
 * Class Action
 * @package app\_\components
 */
class Action extends Web
{
    /** @var string  */
    public $error   = '';

    public function init()
    {
        parent::init();

        $this->test( App::$route->action );

        $this->id = ( $this->isExist() )
            ? App::$route->action
            : ACTION_ERROR;
    }

    /**
     * @param string $actionName
     * @return bool
     */
    public function isExist( $actionName = '' )
    {
        $controller = App::$controller->getClass();
        $controller = new $controller([]);

        $action     = ( !empty($actionName) ) ? $actionName : $this->getName();

        return method_exists( $controller, $action );
    }

    /**
     * @param string $actionName
     * @return string
     */
    public function getName( $actionName = '' )
    {
        $actionName = ACTION_PREFIX . ( ( empty($actionName) ) ? $this->id : $actionName );

        return $actionName;
    }
}