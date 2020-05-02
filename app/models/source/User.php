<?php

namespace app\models\source;

use app\_\base\BaseModel;

/**
 * Class User
 * @package app\models
 */
class User extends BaseModel {

    public $isGuest = true;

    public $name    = '';

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->isGuest ? 'Гость' : $this->name;
    }
}