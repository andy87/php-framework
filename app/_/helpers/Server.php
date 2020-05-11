<?php

namespace _\helpers;

use _\components\Library;

/**
 * Class Server
 * @package app\_\components\library
 */
class Server extends Library
{
    /**
     * Server constructor.
     * @param array $data
     */
    function __construct( $data = [])
    {
        parent::__construct( $data );

        $this->setLibrary( $_SERVER );
    }

    /**
     *      Возвращает данные сервера
     *
     * @return bool
     */
    public static function getData()
    {
        // При неолбходимости тут можно отфильтровать ответ
        return $_SERVER;
    }
}