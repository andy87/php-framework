<?php

namespace controllers;

use _\App;
use _\base\BaseController;
use _\components\DB;
use models\User;

/**
 *  Controller: Profile
 *
 * @package controllers
 */
class ProfileController extends BaseController
{

    /**
     * @param string $userName
     * @param int $role
     * @return string
     */
    public function actionByUserName( $userName = '', $role = 0 )
    {
        $data = [
            'userName'  => $userName
        ];

        return $this->render( 'index', $data );
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionById( $id = 0 )
    {
        $data = [
            'id'        => $id
        ];

        return $this->render( 'index', $data );
    }
}
