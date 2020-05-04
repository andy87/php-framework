<?php

namespace app\_\base;

use app\_\App;
use app\_\components\Web;

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
     * @return array
     */
    public function rules()
    {
        //TODO: правила доступа к экшонам по методу запроса
        return [];
    }

    /**
     * @param $templateName string
     * @param $params array
     * @return string
     */
    public function render( $templateName, $params )
    {
        $resp = $this->renderFile( $templateName, $params );

        if ( $layout = App::$view->layout )
        {
            $pathTemplateLayout = App::$view->layoutDir . $layout;

            $resp = $this->renderFile( $pathTemplateLayout, [
                'content' => $resp
            ]);
        }

        return $resp;
    }

    /**
     * @param $templateName string
     * @param $params array
     * @return string
     */
    public function renderFile( $templateName, $params )
    {
        return App::$view->render( $templateName, $params );
    }

    /**
     * @param $e \Exception
     * @return string
     */
    public function actionError( $e )
    {
        App::$view->registerCssFile('/css/error.css');

        $data = [
            'error'     => $e,
            'message'   => $e->getMessage()
        ];

        $template = '@root/' . TEMPLATE_ERROR;

        return $this->render( $template, $data );
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
        $controllerClassName    = array_pop(explode('/', __CLASS__) );

        return str_replace( CONTROLLER_SUFFIX, '', $controllerClassName );
    }
}