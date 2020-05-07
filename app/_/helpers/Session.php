<?php

namespace _\helpers;

use _\components\Library;

/**
 * Class Session
 * @package app\_\components\library
 */
class Session extends Library
{
    /**
     * Session constructor.
     * @param array $data
     */
    function __construct( $data = [] )
    {
        parent::__construct( $data );

        $this->setLibrary( $_SESSION );
    }

    /**
     *      Возвращает данные сессии
     *
     * @return bool
     */
    public static function getData()
    {
        // При неолбходимости тут можно отфильтровать ответ
        return ( session_status() ? $_SESSION : false );
    }
}