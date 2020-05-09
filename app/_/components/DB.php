<?php

namespace _\components;

use _\App;
use PDO;
use _\base\Core;
use PDOStatement;


/**
 *      Клас управления базой данных
 *
 * @package app\_\components
 */
class DB extends Core
{
    /**
     *      Ссылка на подключение
     *
     * @var PDO
     */
    private $connection = null;

    /**
     *      Рекизиты доступа к БД
     *
     * @var array
     */
    private $setups     = [
        'dsn'           => null,
        'username'      => null,
        'password'      => null,
        'charset'       => null,
    ];

    /**
     * DB constructor.
     * @param array $params
     */
    function __construct( $params = [] )
    {
        parent::__construct( $params );

        if ( isset($GLOBALS['params']['setups']['db']) )
        {
            $this->setups = params('setups.db');

            $this->connection();

            unset($GLOBALS['params']['setups']['db']);
        }
    }

    /**
     * @return PDO
     */
    public function connection()
    {
        if ( ! $this->connection )
        {
            if ( !App::$db->connection )
            {
                $this->connection = new PDO( $this->setups['dsn'], $this->setups['username'], $this->setups['password'] );
            }
        }

        return $this->connection;
    }

    /**
     * @param string $sql
     * @return false|PDOStatement
     */
    public function query( $sql )
    {
        if ( ! $this->connection )
        {
            $this->connection();
        }

        return $this->connection->query( $sql );
    }
}