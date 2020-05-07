<?php

namespace models;

use \models\source\User as Source;

/**
 * Class User
 * @package app\models
 */
class User extends Source
{
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