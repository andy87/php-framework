<?php

namespace _\components\main;

use _\App;
use _\base\Core;
use _\components\Library;
use _\components\Runtime;
use _\helpers\Cookie;
use _\helpers\Server;
use _\helpers\Session;

/**
 * Class Request
 * @package app\_\components
 */
class Request extends Core
{
    /** Возможные методы отбаботки запроса */
    const METHOD_GET        = 'GET';
    const METHOD_POST       = 'POST';
    const METHOD_AJAX       = 'AJAX';
    const METHOD_PUT        = 'PUT';
    const METHOD_UPDATE     = 'UPDATE ';
    const METHOD_DELETE     = 'DELETE';
    const METHOD_HEAD       = 'HEAD';
    const METHOD_CONNECT    = 'CONNECT';
    const METHOD_OPTIONS    = 'OPTIONS';
    const METHOD_TRACE      = 'TRACE';
    const METHOD_PATCH      = 'PATCH';


    /** @var string фактический адрес запроса ( URL/URI ) */
    public $uri     = '';

    /** @var array Разбитый по слэшу ( URL/URI ) */
    public $path    = [];

    /** @var string фактический метод запроса */
    public $method  = 'GET';



    // Определение метода
    /** @var bool статус запроса методом GET */
    public $isGet       = false;

    /** @var bool статус запроса методом POST */
    public $isPost      = false;

    /** @var bool статус запроса методом AJAX */
    public $isAjax      = false;

    /** @var bool статус запроса методом PUT */
    public $isPut       = false;

    /** @var bool статус запроса методом UPDATE */
    public $isUpdate    = false;

    /** @var bool статус запроса методом DELETE */
    public $isDelete    = false;

    /** @var bool статус запроса методом HEAD */
    public $isHead      = false;

    /** @var bool статус запроса методом CONNECT */
    public $isConnect   = false;

    /** @var bool статус запроса методом OPTIONS */
    public $isOptions   = false;

    /** @var bool статус запроса методом TRACE */
    public $isTrace     = false;

    /** @var bool статус запроса методом PATCH */
    public $isPatch     = false;



    // свойства для работы с объектами
    /** @var bool|Server данные SERVER*/
    public $server      = true;

    /** @var bool|Library _GET данные */
    public $get         = true;

    /** @var bool|Library _POST данные  */
    public $post        = true;

    /** @var bool|Library данные _FILES */
    public $files       = false;

    /** @var bool|Cookie данные COOKIE */
    public $cookie      = false;

    /** @var bool|Session данные SESSION */
    public $session     = false;


    /** @var array список используемых метобов */
    private $useMethodList  = [];

    /** @var bool Признак использования Runtime Logs */
    public $runtime         = false;

    /**
     * Request constructor.
     * @param $params array
     */
    function __construct( $params )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        parent::__construct( $params );

        $requestParams          = $params[ $this->getClassName( true ) ];

        $this->useMethodList    = $requestParams['methods'];

        /** @var Server server */
        $this->server       = new Server( $_SERVER );

        $this->uri          = $this->getUri();
        $this->path         = explode(SLASH, $this->uri);
        $this->method       = $this->getMethod();

        $this->setupMethodStatus();

        $this->arguments    = $_REQUEST;

        // Назначение свойств get, post, files, cookie, session
        $requestObjects     = ['get','post','files','server','cookie','session'];

        foreach ( $requestObjects as $key )
        {
            if ( !$this->$key ) continue;

            $func = 'obj' . ucfirst( $key );

            $item = $this->$func();

            if ( $item->data ) $this->{$item->key}  = new $item->class( $item->data );
        }
    }

    /**
     *      Получение объекта $_GET (для перебора)
     *
     * @return object
     */
    private function objGet()
    {
        return $this->objRequestData( $_GET, 'get', "_\\components\\Library");
    }

    /**
     *      Получение объекта $_POST (для перебора)
     *
     * @return object
     */
    private function objPost()
    {
        return $this->objRequestData( $_POST, 'post', "_\\components\\Library");
    }

    /**
     *      Получение объекта $_FILES (для перебора)
     *
     * @return object
     */
    private function objFiles()
    {
        return $this->objRequestData( $_FILES, 'files', "_\\components\\Library");
    }

    /**
     *      Получение объекта Server (для перебора)
     *
     * @return object
     */
    private function objServer()
    {
        return $this->objRequestData( Server::getData(), 'server', "_\\helpers\\Server");
    }

    /**
     *      Получение объекта Cookie (для перебора)
     *
     * @return object
     */
    private function objCookie()
    {
        return  $this->objRequestData( Cookie::getData(), 'cookie', "_\\helpers\\Cookie");
    }

    /**
     *      Получение объекта Session (для перебора)
     *
     * @return object
     */
    private function objSession()
    {
        return  $this->objRequestData( Session::getData(), 'session', "_\\helpers\\Session");
    }

    /**
     *      конструктор объекта для перебора элементов self::$request
     *
     * @param $data
     * @param $ket
     * @param $class
     * @return object
     */
    private function objRequestData( $data, $ket, $class )
    {
        return (object) [
            'key'       => $ket,
            'class'     => $class,
            'data'      => $data,
        ];
    }

    /**
     *      Получение URI запроса
     *
     * @return string
     */
    private function getUri()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $resp = $this->server->get( 'REQUEST_URI', SLASH );

        if ( $resp )
        {
            $arr    = explode( '?', $resp );
            $resp   = array_shift( $arr );
        }

        return $resp;
    }

    /**
     *      Получение метода использованного при запросе
     *
     * @return mixed
     */
    private function getMethod()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return $this->server->get( 'REQUEST_METHOD', null );
    }

    /**
     *      Проставление статуса методов запроса
     */
    private function setupMethodStatus()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $method = 'is' . ucfirst( strtolower( $this->method ) );

        $this->{$method} = true;

        $this->isAjax = $this->isAjax();
    }

    /**
     *      Проверка запроса на соответствие типа AJAX
     *
     * @return bool
     */
    private function isAjax()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return ( strtolower( $this->server->get( 'HTTP_X_REQUESTED_WITH' ) ) == strtolower( AJAX ) );
    }


    /**
     *      Сравнение метода запроса
     *
     * @param $method string|null
     * @return bool
     */
    public function isMethod( $method = null )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return ( $method AND strtolower( $this->getMethod() ) === strtolower( $method ) );
    }

    /**
     *      Возвращает true если запрос содержал аргументы
     *
     * @return bool
     */
    public function hasArguments()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return isset( $this->arguments );
    }

    /**
     *      Возвращает список аргументов переданных в запросе
     *
     * @return array
     */
    public function getArguments()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return App::$route->arguments;
    }
}