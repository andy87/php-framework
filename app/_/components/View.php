<?php

namespace app\_\components;

use app\_\App;
use app\_\base\BaseComponent;

/**
 * Class View
 * @package app\_\components
 */
class View extends BaseComponent
{
    /**TODO: `как их описать правильно?` */
    const POS_HEAD      = 0;
    const POS_BODY      = 1;
    const POS_FOOTER    = 2;

    /** @var string кодировка докуменда */
    public $charset = DEFAULT_CHARSET;

    /** @var string заголовок приложения */
    public $title = 'My Application';

    /** @var array массив подключаемых CSS файлов */
    private $css = [];

    /** @var array массив подключаемых JS файлов */
    private $js  = [
        // head
        0 => [],

        // body
        1 => [],

        // footer
        2 => [],
    ];

    /** @var array данные для формирования Меты */
    private $meta = [];

    /** @var array стандартные опции подключаемых JS файлов */
    private $defaultJsOptions = [
        'position'  => self::POS_FOOTER,
        'depends'   => null
    ];

    /** @var string дирректория в которой хранятся обёртки */
    public $layoutDir   = '@views/_layouts/';

    /** @var string имя обёртки исполоьзуемой при render() */
    public $layout      = 'main';


    function __construct($params = [])
    {
        parent::__construct($params);
    }

    /**
     *      Регистрируем JS файл для включения в контент
     *
     * @param $path
     * @param array $option
     * @param string $id
     */
    public function registerJsFile( $path, $option = [], $id = '' )
    {
        $option = array_merge( $this->defaultJsOptions, $option );

        $this->js[ $option['position'] ][ $id ] = [ $path, $option['depends'] ];
    }

    /**
     *      Регистрируем CSS файл для включения в контент
     *
     * @param $path
     */
    public function registerCssFile( $path )
    {
        $this->css[] = $path;
    }

    /**
     * @param $meta string|array
     */
    public function registerMeta( $meta )
    {
        $this->meta[] = $meta;
    }

    /**
     *      Основной рендер
     *
     * @param string $pathTemplate
     * @param array $params
     * @return string
     */
    public function render( $pathTemplate = '', $params = [] )
    {
        $resp = '';

        if ( strpos( $pathTemplate, DOG) === false )
        {
            $pathTemplate = '@views' . SLASH . App::$route->controller . SLASH. $pathTemplate;
        }

        $pathTemplate = App::getAlias( $pathTemplate );

        if ( strpos($pathTemplate, TEMPLATE_FORMAT) == false )
        {
            $pathTemplate .= TEMPLATE_FORMAT;
        }


        if ( ! file_exists( $pathTemplate ) )
        {
            $error = [
                'error'     => 'Template not found',
                'message'   => $pathTemplate
            ];
            $this->exception( $error );
        }

        try {

            extract($params);

            ob_start();

            require_once $pathTemplate;

            $resp = ob_get_contents();

            ob_end_clean();

        } catch ( \Exception $e ) {

            $this->exception( $e->getMessage() );
        }

        return $resp;
    }

    public function head()
    {
        echo $this->renderMeta();
        echo $this->renderCss();
        echo $this->renderJs( View::POS_HEAD );
    }

    public function body()
    {
        echo $this->renderJs( View::POS_BODY );
    }

    public function footer()
    {
        echo $this->renderJs( View::POS_FOOTER );
    }


    private function renderMeta()
    {
        //TODO: сделать renderMeta
        return '';
    }

    private function renderCss()
    {
        //TODO: сделать renderCss
        return '';
    }

    private function renderJs( $position )
    {
        //TODO: сделать renderJs
        return '';
    }
}