<?php

namespace _\helpers;

use _\components\Library;

/**
 * Class Cookie
 * @package app\_\components\library
 */
class Cookie extends Library
{
    /**
     * Cookie constructor.
     * @param array $data
     */
    function __construct( $data = [] )
    {
        parent::__construct( $data );

        $this->setLibrary( $_COOKIE );
    }

    /**
     *      Возвращает данные кукисов
     *
     * @return bool
     */
    public static function getData()
    {
        // При неолбходимости тут можно отфильтровать ответ
        return $_COOKIE;
    }
}