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
        return [];
    }

    /**
     * @param $templateName string
     * @param $data array
     * @return string
     */
    public function render( $templateName, $data )
    {
        $templatePath = App::getAlias( $templateName );

        return '';
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