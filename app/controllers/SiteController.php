<?php

namespace controllers;

use _\base\BaseController;
use _\models\Migration;

/**
 * Class SiteController
 *
 *  Главный контроллер
 *
 * @package app\controllers
 */
class SiteController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $data = [
            'class'      => __CLASS__,
            'method'  => __METHOD__,
        ];

        return $this->render( 'index', $data );
    }

    /**
     * @return string
     */
    public function actionLogin()
    {
        $data = [
            'class'      => __CLASS__,
            'method'  => __METHOD__,
        ];

        return $this->render( 'login', $data );
    }

    /**
     * @return string
     */
    public function actionContact()
    {
        $data = [
            'class'     => __CLASS__,
            'method'    => __METHOD__,
        ];

        return $this->render( 'contact', $data );
    }

    /**
     * @return string
     */
    public function actionTest()
    {

        /** @var Migration $migrationItem */
        $migrationItem = Migration::get()
            ->select('name,timestamp')
            ->where(['id','<', 30 ])
            ->all();


        exit('Плохой, плохой exit() !');
    }
}