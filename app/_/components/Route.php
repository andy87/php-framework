<?php

namespace app\_\components;

use app\_\App;

/**
 * Class Route
 * @package app\_\components
 */
class Route extends Core
{
    /** @var string строка URI запроса */
    public $request = '';

    /** @var array пути сзявывания контроллеров с URI */
    public $rules = [];

    /** @var array данные подходящего route */
    public $rout = [
        'key'       => '',
        'data'      => '',
    ];

    /** @var string контроллер полученый из route  */
    public $controller  = '';

    /** @var string экшон полученый из route */
    public $action      = '';


    /**
     * Rout constructor.
     * @param $params
     */
    function __construct( $params )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        parent::__construct( $params );

        $this->setRules( $params[ 'routes' ] );

        $this->setRequest();

        $this->checkRules();
    }

    /**
     * @param $rules
     */
    public function setRules( $rules )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( count($rules) )
        {
            $this->rules = $rules;
        }
    }

    /**
     *
     */
    private function setRequest()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->request = ( App::$request->uri !== SLASH )
            ? substr( App::$request->uri, 1 )
            : SLASH;
    }

    /**
     *
     */
    private function checkRules()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        foreach ( $this->rules as $uri => $params )
        {
            if ( $this->checkMatch( $this->request, $uri ) )
            {
                $this->rout = [
                    'key'       => $uri,
                    'data'      => $this->slashReplace( $params )
                ];
                break;
            }
        }

        if ( empty($this->rout) )
        {
            $this->rout = [
                'key'       => null,
                'data'      => DEFAULT_CONTROLLER . SLASH . ACTION_ERROR
            ];
        }

        $params = explode(SLASH, $this->rout['data'] );

        $this->controller   = $params[0];
        $this->action       = $params[1];
    }

    /**
     * @param string $request
     * @param string $rule
     * @return bool
     */
    private function checkMatch( $request, $rule )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        return ( $request === $rule );
    }
}