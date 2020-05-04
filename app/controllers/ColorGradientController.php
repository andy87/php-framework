<?php

namespace app\controllers;

use app\_\App;
use app\_\base\BaseController;

class ColorGradientController extends BaseController
{
    public function rules()
    {
        return [
            'actionLinearGradient' => ['GET', 'POST'],
            'actionRadialGradient' => 'POST'
        ];
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