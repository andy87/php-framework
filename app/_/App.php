<?php

namespace app\_;

use app\_\base\Core;
use app\_\components\Runtime;
use app\_\components\main\Request;
use app\_\components\main\Route;
use app\_\components\main\Response;
use app\_\components\main\View;
use app\_\base\BaseController;
use app\_\helpers\Controller;

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

    /**
     * App constructor.
     * @param $params array
     */
    function __construct( $params )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

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

        self::setCharset( self::getParams('charset', DEFAULT_CHARSET ) );
    }

    /**
     *      Технический метод.
     *          Поочерёдно устанавливает свойства необходимые для работы приложения
     *
     * @param $params
     */
    private function initParams( $params )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

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
        Runtime::log(static::class, __METHOD__, __LINE__ );

        self::$alias = $aliases;

        self::$alias[ "system" ] = '=========';

        self::$alias['@app'] = SLASH . 'app';

        foreach ( DIRECTORY_APP as $dir )
        {
            self::$alias[ "@{$dir}" ] = self::slashReplace(self::$alias['@app'] . SLASH . self::slashReplace( $dir ) );
        }

        self::$alias[ "static" ] = '=========';

        foreach ( DIRECTORY_STATIC as $static )
        {
            self::$alias[ "@{$static}" ] = SLASH . $static;
        }
    }



    /**
     *      Связывает путь к файлу с alias диррекориями
     *
     * @param string $path      '@root/README.md'|'@css/...'|'@controlles/...'
     * @param bool $full        // TRUE - для получения полного пути
     * @return string
     */
    public static function getAlias( $path, $full = false )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $resp = self::slashReplace( $path );

        if ( strpos( $path, DOG ) === 0 )
        {
            $data   = explode(SLASH, $path );

            $alias  = array_shift($data );

            $resp   = str_replace($alias, self::$alias[ $alias ], $path );
        }

        if ( $full ) $resp = self::$alias['@root'] . SLASH . $resp;

        return $resp;
    }


    /**
     *      Метод задаёт кодировку сразу представлению и ответу
     *
     * @param string $charset
     */
    public static function setCharset( $charset )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

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
        Runtime::log(static::class, __METHOD__, __LINE__ );

        return ( isset(self::$params[ $key ]) ) ? self::$params[ $key ] : $default;
    }

    /**
     *
     */
    public function init()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( !self::$controller->exists )
        {
            $this->exception( [
                'message'       => 'Controller not found.',
                'error'         => "Controller ID: " . self::$controller->id
            ], 404);
        }

        if ( !self::$controller->action->exists )
        {
            $this->exception( [
                'message'       => 'Action not found.',
                'error'         => "Action ID: " . self::$controller->action->id
            ], 404);
        }

        $classController = self::$controller->getClass();

        /** @var BaseController $controller */
        $controller = new $classController( self::$params );

        $action     = self::$controller->action->getName();

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

            if ( $layout = self::$view->layout )
            {
                $pathTemplateLayout = self::$view->layoutDir . $layout;

                $resp = self::$view->render( $pathTemplateLayout, [
                    'content' => $resp
                ]);
            }

            self::$response->setContent( $resp );

            $controller->afterAction();

        } catch ( \Exception $e ) {

            //TODO: обработчик ошибок https://habr.com/ru/post/440744/
            $controller = new BaseController([]);
            $resp       = $controller->actionError([
                'error'         => $e->getCode(),
                'message'       => $e->getMessage(),
            ]);

            self::$response->setContent( $resp );
        }

        $this->debug();

        self::$response->sendHeaders();
    }



    /**
     *
     */
    public static function display()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( isset(self::$params['request']['runtime']) AND self::$params['request']['runtime'] == true )
        {
            Runtime::load();
        }

        $resp = self::$response->getContent();

        if ( self::$response->isFile )
        {
            self::$response->redirect( $resp, 301 );
        }

        echo $resp;

        exit();
    }



    /**
     * @param string $name
     * @return array
     */
    public static function params( $name = '' )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $paramsList = ( !empty($name) ) ? [$name] : array_keys(get_class_vars( App::class ));

        $resp = [];

        foreach ( $paramsList as $param )
        {
            $resp[ $param ] = self::$$param;
        }

        return $resp;
    }



    /**
     *
     */
    private function debug()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

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

            self::display();
        }
    }


}