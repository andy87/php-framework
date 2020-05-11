<?php

namespace models\source;

use _\base\BaseModel;
use _\components\Runtime;

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
        Runtime::log( static::class, __METHOD__, __LINE__ );

        return $this->isGuest ? 'Гость' : $this->name;
    }
}