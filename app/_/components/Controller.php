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
     */
    public function init()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->setTarget();

        /** @var Action action */
        $this->action       = new Action( App::$params );
    }

    private function setTarget()
    {
        $this->target = $this->id . CONTROLLER_SUFFIX;
    }

    /**
     *      Получить правильное имя контроллера
     *
     * @param string $name
     * @param bool $full        // включая namespace
     * @return string
     */
    public function getClass( $name = '', $full = true )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $className  = ( empty($name) ) ? $this->id : $name;
        $className .= ( $full ) ?  CONTROLLER_NAMESPACE : '';
        $className .= $className . CONTROLLER_SUFFIX;

        return $className;
    }

    /**
     *      Проверка на существование файла запрашываемого контроллера
     *
     * @return bool
     */
    public function isExist()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

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
        Runtime::log(static::class, __METHOD__, __LINE__ );

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