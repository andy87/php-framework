<?php

namespace app\_;

use app\_\base\BaseComponent;
use app\_\base\BaseController;
use app\_\components\Request;
use app\_\components\Response;
use app\_\components\Controller;
use app\_\components\View;
use app\_\components\Route;

/**
 * Class App
 *
 *      Ядрышко фреймворка
 *
 * @package _core\components
 */
class App extends BaseComponent
{
    /** @var array */
    public static $alias = DIRECTORY_LIST;

    /** @var array */
    public static $params = [];

    /** @var Request */
    public static $request;

    /** @var Response */
    public static $response;

    /** @var Controller */
    public static $controller;

    /** @var View */
    public static $view;

    /** @var Route */
    public static $route;




    /**
     * App constructor.
     * @param $params array
     */
    function __construct( $params )
    {
        parent::__construct( $params );

        self::$params = $params;

        /** @var Request request */
        self::$request      = new Request( $params );

        /** @var Route controller */
        self::$route         = new Route( $params );

        /** @var Response response */
        self::$response     = new Response( $params );

        /** @var Controller controller */
        self::$controller   = new Controller( $params );

        /** @var View controller */
        self::$view         = new View( $params );


        $this->initParams( $params );
    }

    /**
     * @param $params
     */
    private function initParams( $params )
    {
        $this->setAlias( $params['alias'] );
    }

    /**
     * @param $aliases array
     */
    public function setAlias( $aliases )
    {
        $app = str_replace('/config', '', App::slashReplace( $aliases['config'] ) );

        App::$alias = [
            'root'      => str_replace('/app', '', $app),
            'app'       => $app
        ];

        foreach ( DIRECTORY_LIST as $dir )
        {
            App::$alias[ $dir ] = App::slashReplace("$app/{$dir}");
        }
    }

    /**
     * @param $path
     * @return string
     */
    public static function getAlias( $path )
    {
        $resp = App::slashReplace( $path );

        if ( strpos( $path, DOG ) === 0 )
        {
            $path   = explode(SLASH, $path );

            $alias  = array_shift($path );
            $alias  = str_replace(DOG,'', $alias );

            $resp   = App::$alias[ $alias ] . SLASH . implode(SLASH, $path );
        }

        return $resp;
    }



    /**
     * @return mixed
     */
    public function display()
    {
        $isClassExist = App::$controller->isExist();

        $classController = ( $isClassExist ) ? '' : ucfirst(DEFAULT_CONTROLLER);
        $classController = App::$controller->getClass( $classController );

        /** @var BaseController $controller */
        $controller = new $classController( App::$params );

        $action     =  ( $isClassExist AND App::$controller->action->isExist() ) ? '' : ucfirst(ACTION_ERROR );
        $action     = App::$controller->action->getName( $action );

        try
        {
            $controller->beforeAction();

            if ( self::$request->hasArguments() )
            {
                $arguments  = self::$request->getArguments();

                $resp   = $controller->{$action}( $arguments );

            } else {

                $resp   = $controller->{$action}();
            }

            $controller->afterAction();

        } catch ( \Exception $e ) {

            //TODO: https://habr.com/ru/post/440744/

            $controller = new BaseController([]);

            $resp = 'error'; $controller->actionError( $e );
        }

        $this->test( $resp );

        self::$response->sendHeaders();

        return $resp;
    }

}


// IT Директор
// Senior

// TeamLead
// Middle

// Jun