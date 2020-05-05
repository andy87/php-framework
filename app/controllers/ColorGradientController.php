<?php

namespace app\controllers;

use app\_\App;
use app\_\base\BaseController;
use app\_\components\main\Response;

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
            'block'         => $this->render('block', [
                'text' => "test"
            ])
        ];

        return $this->render('linear-gradient', $data );
    }

    /**
     * @return string
     */
    public function actionRadialGradient()
    {
        $this->addMetas( __METHOD__ );

        $data = [
            'from'          => "#fff",
            'to'            => "#000",
            'controller_id' => $this->id,
            'block'         => $this->render('block', [
                'text' => "test"
            ])
        ];

        return $this->render('radial-gradient', $data );
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

        return $this->renderJson($data);
    }

    public function addMetas( $content )
    {
        App::$view->registerMeta(['name' => 'action', 'content'=> $content]);
    }


    // TODO: взаимодействие с БД
    // DB::table('users')->sql( $sql )->exec();
    // $user = User::getAll();
    // $user = User::find()->where(['id' => 1])->all();
    // $user = User::find()->select('*')->where(['id' => 1])->all();
    // $user = User::find()->select('name, id')->where(['name', 'LIKE', 'and_y87'])->one();
    // $user_id = $user->id;

}