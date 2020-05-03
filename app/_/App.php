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
    /** @var array некие параметры */
    public static $params = [];

    /** @var array пути в основные дирректории проекта */
    public static $alias = DIRECTORY_LIST;

    /** @var Request данные запроса*/
    public static $request;

    /** @var Route данные путей */
    public static $route;

    /** @var Controller данные контроллера */
    public static $controller;

    /** @var View данные отображения */
    public static $view;

    /** @var Response данные ответа */
    public static $response;


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

        //TODO: эй ты! где фиксация ошибки 404 ?

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

            self::$response->setContent( $resp );

            $controller->afterAction();

        } catch ( \Exception $e ) {

            //TODO: https://habr.com/ru/post/440744/

            $controller = new BaseController([]);
            $resp = $controller->actionError( $e );

            self::$response->setContent( $resp );
        }

        $this->debug();

        self::$response->sendHeaders();

        $response = self::$response->getContent();

        return $response;
    }

    /**
     *
     */
    private function debug()
    {
        $key = 'debug';

        if ( self::$request->get->_isset($key ) )
        {
            $filter = self::$request->get->get($key, false );

            if ( $filter )
            {
                $data = self::$$filter;

            } else {

                $data = [
                    '$params'   => self::$params,
                    '$alias'    => self::$alias,
                    '$request'  => self::$request,
                    '$route'    => self::$route,
                    '$controller'   => self::$controller,
                    '$view'     => self::$view,
                    '$response'     => self::$response,
                ];
            }

            self::printPre( $data );
        }
    }

}