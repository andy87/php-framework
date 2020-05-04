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

    /** @var array объекты и свойства приложения */
    public static $paramsList = ['params','alias','request','route','controller','view','response'];


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

        self::setCharset( App::getParams('charset', DEFAULT_CHARSET ) );

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
     *      Задаём кодировку
     *
     * @param string $charset
     */
    public static function setCharset( $charset )
    {
        self::$view->charset = $charset;
        self::$response->setCharset( $charset );
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
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public static function getParams( $key, $default = null )
    {
        return ( isset(App::$params[ $key ]) ) ? App::$params[ $key ] : $default;
    }


    /**
     *
     */
    public function init()
    {
        $isClassExist = App::$controller->isExist();

        if ( !$isClassExist )
        {
            $this->exception( [
                'message'     => 'Controller not found.',
                'error'   => "Controller ID: " . App::$controller->id
            ], 404);
        }

        $isActionExist = App::$controller->action->isExist();

        if ( !$isActionExist )
        {
            $this->exception( [
                'message'     => 'Action not found.',
                'error'   => "Action ID: " . App::$controller->action->id
            ], 404);
        }

        $classController = App::$controller->getClass();

        /** @var BaseController $controller */
        $controller = new $classController( App::$params );

        $action     = App::$controller->action->getName();

        try
        {
            if ( count( $rules = $controller->rules() ) )
            {
                self::$controller->rules = $rules;

                if ( ( $error = self::$controller->accessRules() ) !== true )
                {
                    $this->exception( $error, 403 );
                }
            }

            $controller->beforeAction();

            if ( self::$request->hasArguments() )
            {
                $arguments  = self::$request->getArguments();

                $resp   = $controller->{$action}( $arguments );

            } else {

                $resp   = $controller->{$action}();
            }

            if ( $layout = App::$view->layout )
            {
                $pathTemplateLayout = App::$view->layoutDir . $layout;

                $resp = App::$view->render( $pathTemplateLayout, [
                    'content' => $resp
                ]);
            }

            self::$response->setContent( $resp );

            $controller->afterAction();

        } catch ( \Exception $e ) {

            //TODO: обработчик ошибок https://habr.com/ru/post/440744/

            $controller = new BaseController([]);
            $resp       = $controller->actionError( $e );

            self::$response->setContent( $resp );
        }

        $this->debug();

        self::$response->sendHeaders();
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

                $data = self::params();
            }

            var_dump($data);
            exit();
        }
    }

    /**
     * @param string $name
     * @return array
     */
    public static function params( $name = '' )
    {
        $paramsList = ( !empty($name) ) ? [$name] : self::$paramsList;

        $resp = [];

        foreach ( $paramsList as $param )
        {
            $resp[ $param ] = self::$$param;
        }

        return $resp;
    }
}