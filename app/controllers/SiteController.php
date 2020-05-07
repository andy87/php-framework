<?php

namespace controllers;

use _\base\BaseController;
use app\models\User;

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
        $user       = User::getData();
        $username   = $user->getUserName();

        $data = [
            'user'      => $user,
            'username'  => $username,
        ];

        return $this->render( 'index', $data );
    }
}