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

    /**
     * Action constructor.
     * @param array $params
     */
    public function init( $params = [])
    {
        $this->id = ( $this->isExist() )
            ? App::$route->action
            : ACTION_ERROR;

        $this->setTarget();
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


    private function setTarget()
    {
        $this->target = ACTION_PREFIX . $this->id;
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