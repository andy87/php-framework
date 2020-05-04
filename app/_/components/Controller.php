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

    /** @var array правила доступа к экшонам в зависимости от метода */
    public $rules = [];



    /**
     * Controller constructor.
     *
     * @param $params array
     */
    function __construct( $params )
    {
        parent::__construct( $params );

        /** @var Action action */
        $this->action       = new Action( $params );
    }

    /**
     *      Получить правильное имя контроллера
     *
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
     *      Проверка на существование файла запрашываемого контроллера
     *
     * @return bool
     */
    public function isExist()
    {
        $classFilePath = App::$alias['root'] . SLASH . $this->getClass() . PHP;
        $classFilePath = self::slashReplace($classFilePath);

        return file_exists( $classFilePath );
    }

    /**
     *      Проверка на тип вызываемого метода при необходимости
     *
     * @return bool|array
     */
    public function accessRules()
    {
        $result = true;

        $method = App::$request->method;

        foreach ( $this->rules as $action => $rules )
        {
            if ( is_string($rules) ) $rules = [$rules];

            if ( $this->action->getName() == $action AND ! in_array( $method, $rules ) )
            {
                $result = [
                    'message'   => 'Access denied',
                    'error'     => 'Success access methods :' . implode(' ', $rules ),
                ];
            }
        }

        return $result;
    }
}