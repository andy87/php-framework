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
        App::$view->registerJsFile('script.js');

        $data = [
            'from'          => "#fff",
            'to'            => "#000",
            'controller_id' => $this->id
        ];

        //$this->printPre($data);

        return $this->render('linear-gradient', $data );
    }

}