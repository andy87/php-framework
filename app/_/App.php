<?php

namespace _;

use _\base\Core;
use _\components\DB;
use _\components\Runtime;
use _\components\main\Request;
use _\components\main\Route;
use _\components\main\Response;
use _\components\main\View;
use _\components\main\Controller;
use _\base\BaseController;
use Exception;

/**
 * Class App
 *
 *      Ядрышко фреймворка
 *
 * @package _core\components
 */
class App extends Core
{
    /** @var array параметры астроек полученые из \app\config\params.php */
    public static $params = [];

    /** @var array пути в основные дирректории проекта */
    public static $alias = DIRECTORY_APP;

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

    /** @var BaseController пользовательский контроллер */
    public static $app;

    /** @var DB Контроллер соединения с БД */
    public static $db;



    /**
     *      constructor.
     *
     * @param $params array
     */
    function __construct( $params )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        parent::__construct( $params );

        $this->initParams( $params );

        self::$params = $params;

        /** @var Request request */
        self::$request      = new Request( $params );

        /** @var Route controller */
        self::$route         = new Route( $params );

        /** @var Response response */
        self::$response     = new Response( $params );

        /** @var Controller controller */
        ( self::$controller = new Controller( $params ) ) ->setup();

        /** @var View controller */
        self::$view         = new View( $params );

        /** @var DB controller */
        ( self::$db         = new DB( $params ) )->connection();

        self::setCharset( self::getParams( 'charset', DEFAULT_CHARSET ) );

        self::$response->cache();
    }

    /**
     *      Технический метод.
     *          Поочерёдно устанавливает свойства необходимые для работы приложения
     *
     * @param $params
     */
    private function initParams( $params )
    {
        Runtime::$status = ( isset( self::$params['request']['runtime'] ) AND self::$params['request']['runtime'] == true );

        Runtime::log( static::class, __METHOD__, __LINE__ );

        $this->setAlias( $params['alias'] );
    }

    /**
     *      Технический метод.
     *          Метод создаёт в array $alias мэппинг в основные дирректории проекта
     *
     * @param $aliases array
     */
    private function setAlias( $aliases )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        self::$alias = $aliases;

        self::$alias[ "system" ] = '=========';

        self::$alias['@app']        = self::getAlias( '@root/app' );
        self::$alias['@_']          = self::getAlias( '@app/_' );

        self::$alias['@runtime']    = self::getAlias( '@_/runtime' );
        self::$alias['@cache']      = self::getAlias( '@runtime/cache' );

        foreach ( DIRECTORY_APP as $dir )
        {
            self::$alias[ "@{$dir}" ] = self::slashReplace( self::$alias['@app'] . SLASH . $dir );
        }

        self::$alias[ "static" ] = '=========';

        foreach ( DIRECTORY_STATIC as $static )
        {
            self::$alias[ "@{$static}" ] = self::slashReplace( self::$alias['@app'] . SLASH . $static );
        }
    }

    /**
     *      Связывает путь к файлу с alias диррекориями
     *
     * @param string $path      '@root/README.md'|'@css/...'|'@controlles/...'
     * @return string
     */
    public static function getAlias( $path )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $resp = self::slashReplace( $path );

        if ( strpos( $path, DOG ) === 0 )
        {
            $data   = explode( SLASH, $path );

            $alias  = array_shift( $data );

            $resp   = str_replace( $alias, self::$alias[ $alias ], $path );
        }

        return $resp;
    }

    /**
     *      Метод задаёт кодировку сразу представлению и ответу
     *
     * @param string $charset
     */
    public static function setCharset( $charset )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        self::$view->charset = $charset;
        self::$response->setCharset( $charset );
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public static function getParams( $key, $default = null )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return ( isset( self::$params[ $key ] ) ) ? self::$params[ $key ] : $default;
    }

    /**
     *  Иницыализация
     */
    public function init()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        if ( !self::$controller->exists )
        {
            $this->exception( [
                'error' => 'Controller not found.',
                'message' => "Controller ID: " . self::$controller->target
            ], 404 );
        }

        if ( !self::$controller->action->exists )
        {
            $this->exception( [
                'error' => 'Action not found.',
                'message' => "Action ID: " . self::$controller->action->target
            ], 404 );
        }

        $classController = CONTROLLER_NAMESPACE . self::$controller->target;

        /** @var BaseController $controller */
        $controller = new $classController( self::$params );
        self::$app = $controller;

        $action = self::$controller->action->target;

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
                $arguments = self::$request->getArguments();

                $resp = $controller->{$action}( $arguments );

            } else {

                $resp = $controller->{$action}();
            }

            if ( $this->isResponseWrap() )
            {
                $pathTemplateLayout = self::$view->layoutDir . self::$view->layout;

                $resp = self::$view->render( $pathTemplateLayout, [
                    'content' => $resp
                ] );
            }

            self::$response->setContent( $resp );

            $controller->afterAction();

        } catch ( Exception $e ){

            $controller = new BaseController( [] );

            $resp = $controller->actionError( [
                'error' => $e->getCode(),
                'message' => $e->getMessage(),
            ] );

            self::$response->setContent( $resp );
        }

        $this->debug();
    }

    /**
     *      Проверка на необходимость рендеринга обёртки
     *
     * @return bool
     */
    private function isResponseWrap()
    {
        return ( self::$view->layout && self::$response->format == Response::FORMAT_HTML );
    }

    /**
     *  Вывод контента
     */
    public static function display()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        Runtime::push();

        $resp = self::$response->getContent();

        if ( self::$response->isFile )
        {
            self::$response->redirect( $resp, 301 );
        }

        if ( self::$response->format == Response::FORMAT_JSON || is_array( $resp ) )
        {
            $resp = json_encode( $resp );
        }

        self::$response->sendHeaders();

        self::$response->createCache( $resp );

        echo $resp;

        exit();
    }

    /**
     *      Получение параметров App()
     *
     * @param string $name
     * @return array
     */
    public static function params( $name = '' )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $paramsList = ( !empty( $name ) ) ? [$name] : array_keys( get_class_vars( App::class ) );

        $resp = [];

        foreach ( $paramsList as $param )
        {
            $resp[ $param ] = self::$$param;
        }

        return $resp;
    }

    /**
     *      Дебаг
     */
    private function debug()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $key = 'debug';

        if ( isset($_GET[ $key ]) )
        {
            $filter = ( !empty($_GET[ $key ]) ) ? $_GET[ $key ] : false;

            if ( $filter )
            {
                $data = self::$$filter;

            } else {

                $data = self::params();
            }

            var_dump( $data );

            self::display();
        }
    }
}