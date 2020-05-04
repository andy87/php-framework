<?php

namespace app\controllers;

use app\_\App;
use app\_\base\BaseController;

class ColorGradientController extends BaseController
{
    /**
     * @return string
     */
    public function actionLinearGradient()
    {

        App::$view->registerMeta(['name' => 'firstMeta', 'content'=> 'yes']);


        // TODO: взаимодействие с БД
        // DB::table('users')->sql( $sql )->exec();
        // $user = User::getAll();
        // $user = User::find()->where(['id' => 1])->all();
        // $user = User::find()->select('*')->where(['id' => 1])->all();
        // $user = User::find()->select('name, id')->where(['name', 'LIKE', 'and_y87'])->one();

        // $user_id = $user->id;


        $data = [
            'from'          => "#fff",
            'to'            => "#000",
            'controller_id' => $this->id,
            'block'         => $this->renderFile('block', ['text' => "test"])
        ];


        return $this->render('linear-gradient', $data );
    }

}