<?php

namespace _\base;

use _\App;
use _\components\main\Response;
use _\components\Web;

/**
 * Class BaseController
 * @package app\_\base
 */
class BaseController extends Web
{
    /**
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     *
     */
    public function beforeAction(){}

    /**
     *
     */
    public function afterAction(){}


    /**
     *      Кастомный вывод
     *
     * @return string
     */
    public function head()
    {
        return '';
    }

    /**
     *      Кастомный вывод
     *
     * @return string
     */
    public function body()
    {
        return '';
    }

    /**
     *      Кастомный вывод
     *
     * @return string
     */
    public function footer()
    {
        return '';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @param $path string
     * @param $params array
     * @return string
     */
    public function render( $path, $params )
    {
        $resp = null;

        if ( strpos( $path, DOG ) === false )
        {
            $path = '@views' . SLASH . App::$route->controller . SLASH. $path;
        }

        switch ( App::$response->format )
        {
            case Response::FORMAT_RAW:
                $resp = file_get_contents( $path );
                break;

            case Response::FORMAT_HTML:
                $resp = App::$view->render( $path, $params );
                break;
        }

        if ( $resp == null )
        {
            $error = [
                'message'   => "Bad format for rendering",
                'error'     => "Format :  " . App::$response->format ,
            ];
            $this->exception( $error );
        }

        return $resp;
    }

    /**
     *      Рендер JSON
     *
     * @param array $data
     * @return array
     */
    public function renderJson( $data = [] )
    {
        App::$response->format = Response::FORMAT_JSON;

        return $data;
    }

    /**
     * @param array $params
     * @return string
     */
    public function actionError( $params )
    {
        App::$view->registerCssFile( '/css/error.css' );

        $template = '@root/' . TEMPLATE_ERROR;

        return $this->render( $template, $params );
    }

    /**
     * @param $uri
     */
    public function redirect( $uri )
    {
        App::$response->redirect( $uri );
    }

    /**
     * @return string|string[]
     */
    private function getControllerName()
    {
        $controllerClassName    = array_pop( explode( '/', __CLASS__ ) );

        return str_replace( CONTROLLER_SUFFIX, '', $controllerClassName );
    }
}