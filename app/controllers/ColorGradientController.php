<?php

namespace controllers;

use _\App;
use _\base\BaseController;
use _\components\main\Response;
use models\User;

/**
 * Class ColorGradientController
 *
 * @package controllers
 */
class ColorGradientController extends BaseController
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'actionLinearGradient' => ['GET', 'POST'],
            'actionRadialGradient' => 'POST'
        ];
    }

    public function body()
    {
        return '<!-- custom head -->';
    }

    /**
     * @return string
     */
    public function actionLinearGradient()
    {
        $this->addMetas( __METHOD__ );

        $data = [
            'from'          => "#fff",
            'to'            => "#000",
            'controller_id' => $this->id,
            'block'         => $this->render( 'block', [
                'text'          => "test"
            ])
        ];

        $resp = $this->render( 'linear-gradient', $data );

        exit($resp);
    }

    /**
     * @return string
     */
    public function actionLinearGradient2($id)
    {
        $this->addMetas( __METHOD__ );

        $data = [
            'from'          => "#fff",
            'to'            => "#000",
            'controller_id' => $this->id,
            'block'         => $this->render( 'block', [
                'text'          => "test"
            ])
        ];

        return $this->render( 'linear-gradient2', $data );
    }

    /**
     * @return string
     */
    public function actionRadialGradient( $userName )
    {
        $this->addMetas( __METHOD__ );

        $data = [
            'from'          => "#fff",
            'to'            => "#000",
            'controller_id' => $this->id,
            'block'         => $this->render( 'block', [
                'text' => "test"
            ])
        ];

        return $this->render( 'radial-gradient', $data );
    }

    /**
     * @return array
     */
    public function actionReturnJson()
    {
        App::$response->format = Response::FORMAT_JSON;

        $data = [
            'name'  => "Admin",
            'class' => __CLASS__
        ];

        return $data;
    }

    /**
     * @return array
     */
    public function actionReturnJson2()
    {
        $data = [
            'name'  => "Admin",
            'class' => __CLASS__
        ];

        return $this->renderJson( $data );
    }

    public function addMetas( $content )
    {
        App::$view->registerMeta(['name' => 'action', 'content'=> $content]);
    }

    public function badExample()
    {

        $model = User::getData();


    }
}