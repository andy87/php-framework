<?php

namespace controllers;

use _\base\BaseController;

/**
 *  Controller: {{$controllerName}}
 *
 * @package controllers
 */
class {{$controllerName}}Controller extends BaseController
{
    /**
     * @return array
     */
    public function rules()
    {
        return [ 'index' => ['GET'] ];
    }

    public function head() { return '<!-- custom head -->'; }

    public function body() { return '<!-- custom body -->'; }

    public function footer() { return '<!-- custom footer -->'; }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $data = [
            'class'     => __CLASS__,
            'method'    => __METHOD__,
        ];

        return $this->render( 'index', $data );
    }
}
