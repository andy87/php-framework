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
     *      Описание правил доступа к экшонам в зависимости от метода запроса
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     *      Рендер контроллера
     *
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
     *      Стандартный рендер ошибки
     *
     * @param array $params
     * @return string
     */
    public function actionError( $params )
    {
        App::$view->registerCssFile( '/css/error.css' );

        $template = TEMPLATE_ERROR;

        return $this->render( $template, $params );
    }

    /**
     *      Рендер ошибки 404
     *
     * @param array $params
     * @return string
     */
    public function actionError404( $params )
    {
        App::$view->registerCssFile( '/css/error.css' );

        $template ='@app/_/templates/errors/404.php';

        return $this->render( $template, $params );
    }

    /**
     *      Редирект
     *
     * @param $uri
     */
    public function redirect( $uri )
    {
        App::$response->redirect( $uri );
    }

    /**
     *      Получение мени контроллера без суфикса
     *
     * @param string $className
     * @return string|string[]
     */
    private function getControllerName( $className = __CLASS__ )
    {
        $controllerClassName    = array_pop( explode( '/', $className ) );

        return str_replace( CONTROLLER_SUFFIX, '', $controllerClassName );
    }
}