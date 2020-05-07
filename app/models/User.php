<?php

namespace models;

/**
 * Class User
 * @package app\models
 */
class User extends \models\source\User {

    /**
     * @return self
     */
    public static function getData()
    {
        $model = new self();

        /**$model->find()
            ->where( ['id' => App::session( 'id' )] )
            ->one();*/

        return $model;
    }
}