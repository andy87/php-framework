<?php

namespace app\_\components;

use app\_\base\BaseComponent;
use app\_\components\library\Cookie;
use app\_\components\library\Server;
use app\_\components\library\Session;

/**
 * Class Request
 * @package app\_\components
 */
class Request extends BaseComponent
{
    const METHOD_AJAX       = 'AJAX';

    const METHOD_GET        = 'GET';
    const METHOD_POST       = 'POST';

    const METHOD_PUT        = 'PUT';
    const METHOD_UPDATE     = 'UPDATE ';
    const METHOD_DELETE     = 'DELETE';

    const METHOD_HEAD       = 'HEAD';
    const METHOD_CONNECT    = 'CONNECT';
    const METHOD_OPTIONS    = 'OPTIONS';
    const METHOD_TRACE      = 'TRACE';
    const METHOD_PATCH      = 'PATCH';


    /** @var string  */
    public $uri     = '';

    /** @var string  */
    public $method  = 'GET';


    // Определение метода

    /** @var bool  */
    public $isPost  = false;

    /** @var bool  */
    public $isGet   = false;



    /** @var bool  */
    public $isAjax  = false;



    /** @var bool  */
    public $isPut  = false;

    /** @var bool  */
    public $isUpdate  = false;

    /** @var bool  */
    public $isDelete  = false;



    /** @var bool  */
    public $isHead  = false;

    /** @var bool  */
    public $isConnect  = false;

    /** @var bool  */
    public $isOptions  = false;

    /** @var bool  */
    public $isTrace  = false;

    /** @var bool  */
    public $isPatch  = false;



    // свойства для работы с объектами

    /** @var Library  */
    public $get;

    /** @var Library  */
    public $post;

    /** @var Library  */
    public $files;

    /** @var Cookie  */
    public $cookie;

    /** @var Session */
    public $session;

    /** @var Server */
    public $server;

    /** @var array  */
    private $arguments = null;


    private $useMethodList = [];


    /**
     * Request constructor.
     * @param $params array
     */
    function __construct( $params )
    {
        parent::__construct( $params );

        $requestParams          = $params[ $this->getClassName(true) ];

        $this->useMethodList    = $requestParams['methods'];

        /** @var Server server */
        $this->server   = new Server( $_SERVER );

        $this->uri      = $this->getUri();

        $this->method   = $this->getMethod();

        $this->isAjax   = $this->isAjax();

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
     * @return mixed
     */
    private function getUri()
    {
        $resp = $this->server->get('REQUEST_URI', null);

        if ( $resp )
        {
            $resp = array_shift( explode('?', $resp) );
        }

        return $resp;
    }

    /**
     * @return mixed
     */
    private function getMethod()
    {
        return $this->server->get('REQUEST_METHOD', null);
    }

    /**
     *
     */
    private function setupMethodStatus()
    {
        foreach ( $this->useMethodList as $method )
        {
            $method = 'is' . ucfirst(strtolower($method));

            $this->{$method} = $this->{$method}();
        }
    }

    /**
     * @return bool
     */
    private function isPost()
    {
        return ( count($_POST) ) ? true : false;
    }

    /**
     * @return bool
     */
    private function isGet()
    {
        return ( count($_GET) ) ? true : false;
    }

    /**
     * @return bool
     */
    private function isAjax()
    {
        return ( strtolower( $this->server->get('HTTP_X_REQUESTED_WITH') ) == strtolower( AJAX ) );
    }


    /**
     * @param $method string|null
     * @return bool
     */
    public function isMethod( $method = null )
    {
        return ( $method AND strtolower( $this->getMethod() ) === strtolower($method) );
    }

    /**
     * @return bool
     */
    private function isHead()
    {
        return $this->isMethod( self::METHOD_HEAD );
    }

    /**
     * @return bool
     */
    private function isPut()
    {
        return $this->isMethod( self::METHOD_PUT );
    }

    /**
     * @return bool
     */
    private function isUpdate()
    {
        return $this->isMethod( self::METHOD_UPDATE );
    }

    /**
     * @return bool
     */
    private function isDelete()
    {
        return $this->isMethod( self::METHOD_DELETE );
    }

    /**
     * @return bool
     */
    private function isConnect()
    {
        return $this->isMethod( self::METHOD_CONNECT );
    }

    /**
     * @return bool
     */
    private function isOptions()
    {
        return $this->isMethod( self::METHOD_OPTIONS );
    }

    /**
     * @return bool
     */
    private function isTrace()
    {
        return $this->isMethod( self::METHOD_TRACE );
    }

    /**
     * @return bool
     */
    private function isPatch()
    {
        return $this->isMethod( self::METHOD_PATCH );
    }

    /**
     * @return bool
     */
    public function hasArguments()
    {
        return count( $this->getArguments() );
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}