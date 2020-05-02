<?php

namespace app\_\components;

use app\_\App;

/**
 * Class Controller
 * @package app\_\components
 */
class Controller extends Web
{
    /** @var Action */
    public $action;


    /**
     * Controller constructor.
     * @param $params array
     */
    function __construct( $params )
    {
        parent::__construct( $params );

        /** @var Action action */
        $this->action       = new Action( $params );
    }

    /**
     * @param string $name
     * @return string
     */
    public function getClass( $name = '' )
    {
        $className = ( empty($name) )
            ? $this->id
            : $name;


        $className = CONTROLLER_NAMESPACE . $className . CONTROLLER_SUFFIX;

        return $className;
    }

    /**
     * @return bool
     */
    public function isExist()
    {
        $classFilePath = App::$alias['root'] . SLASH . $this->getClass() . PHP;
        $classFilePath = self::slashReplace($classFilePath);

        return file_exists( $classFilePath );
    }
}