<?php

namespace app\_\helpers;

use app\_\App;
use app\_\components\Runtime;
use app\_\components\Web;

/**
 * Class Action
 * @package app\_\components
 */
class Action extends Web
{
    /** @var string  */
    public $error   = '';

    function __construct($params)
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        parent::__construct($params);

        $this->id = ( $this->isExist() )
            ? App::$route->action
            : ACTION_ERROR;

        $this->setTarget();


    }

    /**
     * @param string $actionName
     * @return bool
     */
    private function isExist( $actionName = '' )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $controller = App::$controller->getClass();

        $action     = ( !empty($actionName) ) ? $actionName : $this->getName();

        return method_exists( $controller, $action );
    }

    /**
     *
     */
    private function setTarget()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->target = ACTION_PREFIX . $this->id;
    }

    /**
     * @param string $actionName
     * @return string
     */
    public function getName( $actionName = '' )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $actionName = ACTION_PREFIX . ( ( empty($actionName) ) ? $this->id : $actionName );

        return $actionName;
    }
}