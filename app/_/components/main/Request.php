<?php

namespace _\components\main;


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

    /** @var string фактический метод запроса */
    public $method  = 'GET';



    // Определение метода
    /** @var bool статус запроса методом GET */
    public $isGet   = false;

    /** @var bool статус запроса методом POST */
    public $isPost  = false;

    /** @var bool статус запроса методом AJAX */
    public $isAjax  = false;

    /** @var bool статус запроса методом PUT */
    public $isPut  = false;

    /** @var bool статус запроса методом UPDATE */
    public $isUpdate  = false;

    /** @var bool статус запроса методом DELETE */
    public $isDelete  = false;

    /** @var bool статус запроса методом HEAD */
    public $isHead  = false;

    /** @var bool статус запроса методом CONNECT */
    public $isConnect  = false;

    /** @var bool статус запроса методом OPTIONS */
    public $isOptions  = false;

    /** @var bool статус запроса методом TRACE */
    public $isTrace  = false;

    /** @var bool статус запроса методом PATCH */
    public $isPatch  = false;



    // свойства для работы с объектами
    /** @var Server данные SERVER*/
    public $server;

    /** @var Library _GET данные */
    public $get;

    /** @var Library _POST данные  */
    public $post;

    /** @var Library данные _FILES */
    public $files;

    /** @var Cookie данные COOKIE */
    public $cookie;

    /** @var Session данные SESSION */
    public $session;


    /** @var array аргументы запроса для передачи в Controller->action() */
    private $arguments = null;

    /** @var array список используемых метобов */
    private $useMethodList = [];

    /** @var bool Признак использования Runtime Logs */
    public $runtime = false;

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
        $this->server   = new Server( $_SERVER );

        $this->uri      = $this->getUri();

        $this->method   = $this->getMethod();

        $this->setupMethodStatus();

        $this->arguments    = $_REQUEST;

        /** @var Library get */
        $this->get = new Library( $_GET );

        /** @var Library post */
        $this->post = new Library( $_POST );

        /** @var Library files */
        $this->files = new Library( $_FILES );

        /** @var Cookie cookie */
        $this->cookie = new Cookie( $_COOKIE );

        /** @var Session session */
        $this->session = new Session( $_SESSION );
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
            $resp = array_shift( explode( '?', $resp ) );
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
     * @return bool
     */
    private function isAjax()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return ( strtolower( $this->server->get( 'HTTP_X_REQUESTED_WITH' ) ) == strtolower( AJAX ) );
    }


    /**
     *      Вернёт true если $method == фактический метод запроса
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

        return $this->arguments;
    }
}