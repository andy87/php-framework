<?php

namespace controllers;

use _\base\BaseController;
use models\User;

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
            'class'      => __CLASS__,
            'method'  => __METHOD__,
        ];

        return $this->render( 'contact', $data );
    }
    /**
     * @return string
     */
    public function actionTest()
    {
        $user       = User::getData();
        $username   = $user->getUserName();

        $data = [
            'user'      => $user,
            'username'  => $username,
        ];

        return $this->render( 'index', $data );
    }
}