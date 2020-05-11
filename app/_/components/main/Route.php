<?php

namespace _\components\main;

use _\App;
use _\base\Core;
use _\components\Runtime;

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

    /** @var string совпадение в roles */
    public $match = '';

    /** @var array данные подходящего route */
    public $rout = [
        'key'       => '',
        'data'      => '',
    ];

    /** @var array Аргументы из строки запроса */
    public $arguments = [];

    /** @var string контроллер полученый из route  */
    public $controller  = DEFAULT_CONTROLLER;

    /** @var string экшон полученый из route */
    public $action      = DEFAULT_ACTION;


    /**
     * Rout constructor.
     * @param $params
     */
    function __construct( $params )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        parent::__construct( $params );

        $this->setRequest();

        $this->checkRules();
    }


    /**
     *
     */
    private function setRequest()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $this->request = ( App::$request->uri !== SLASH )
            ? substr( App::$request->uri, 1 )
            : SLASH;
    }

    /**
     *
     */
    private function checkRules()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        //self::printPre( $this );

        foreach ( $this->rules as $uri => $rout )
        {
            if ( $this->checkMatch( $this->request, $uri ) )
            {
                $this->match    = $uri;
                break;
            }
        }

        if ( empty( $this->match ) )
        {
            $this->rout = [
                'rule'      => null,
                'route'     => DEFAULT_CONTROLLER . SLASH . ACTION_ERROR_404
            ];
        }

        $params = explode( SLASH, $this->rout['route']);

        $this->controller   = $params[0];
        $this->action       = $params[1];

        if ( !count($this->arguments) ) $this->arguments = $_GET;

        //TODO: printPre
        //self::printPre($this);
    }

    /**
     *      Проверка на соответствие правилу мэппинга страниц
     *
     * @param string $request   //  URL
     * @param string $rule      // RULE
     * @return bool
     */
    private function checkMatch( $request, $rule )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $result = false;
        $rule   = $this->slashReplace( $rule );

        if ( strpos( $rule, '<' ) === false )
        {
            if ( $result = ( $request === $rule ) )
            {
                $route      = $this->rules[ $rule ];
            }

        } else {

            $ruleData       = explode(SLASH, $rule );
            $routeData      = explode(SLASH, $this->rules[ $rule ] );

            if ( count( $ruleData ) == count( App::$request->path ) )
            {
                $data       = [];

                foreach ( $ruleData as $index => $item )
                {
                    if ( strpos( $item, '<' ) !== false )
                    {
                        if ( strpos( $item, ':' ) !== false )
                        {
                            $regExpData = explode(':', substr( $item, 0, -1 ) );

                            $this->arguments[$index] = substr( array_shift( $regExpData ), 1);

                            $item   = $regExpData[0];

                        } else {

                            $item   = '[\w\d\-\.]';
                        }
                    }

                    $data[ $index ] = $item;
                }

                $pattern    = implode( '+\/+', $data );
                $pattern    = '/^' . $pattern .  '+$/';

                preg_match( $pattern, $request, $match );

                if ( count( $match ) )
                {
                    if ( $this->arguments )
                    {
                        $arguments = [];

                        foreach ( $this->arguments as $index => $name )
                        {
                            $arguments[ $name ] = App::$request->path[ $index ];
                        }

                        $this->arguments    = $arguments;

                    } else {

                        // $requestData
                        //      'gradient-color/<action>' => 'color-gradient/<action>',
                        //      '<action>'                => 'site/<action>',
                        //      '<action>/<controller>'   => '<controller>/<action>',
                        // $ruleData
                        //      gradient-color/test
                        //      qwerty/main
                        //      qwerty/main
                        
                        //$route  = $controller . SLASH . $action;

                        $this->arguments = [];
                    }

                    $result = true;
                }
            }
        }

        if ( $result )
        {
            $this->rout     = [
                'rule'          => $rule,
                'route'         => $route
            ];
        }

        return $result;
    }

}