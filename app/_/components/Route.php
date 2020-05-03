<?php

namespace app\_\components;

use app\_\App;
use app\_\base\BaseComponent;

/**
 * Class Route
 * @package app\_\components
 */
class Route extends BaseComponent
{
    /** @var string  */
    public $request = '';

    /** @var array  */
    public $rules = [];

    /** @var string  */
    public $rout = '';

    /** @var string */
    public $controller  = '';

    /** @var string */
    public $action      = '';

    /**
     * Rout constructor.
     * @param $params
     */
    function __construct( $params )
    {
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
        $this->request = ( App::$request->uri !== SLASH )
            ? substr( App::$request->uri, 1 )
            : SLASH;
    }

    /**
     *
     */
    private function checkRules()
    {
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
        return ( $request === $rule );
    }
}