<?php

namespace _\components;

use PDO;
use _\App;
use _\base\Core;
use PDOException;
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
     * @var array|null
     */
    private $setups     = null;

    /**
     * DB constructor.
     * @param array $params
     */
    function __construct( $params = [] )
    {
        parent::__construct( $params );

        $this->setups = params('setups.db', $params);
    }

    /**
     *      становка соединения с БД
     */
    public function connection()
    {
        if ( $this->setups )
        {
            $this->connection = self::getConnect();
        }
    }

    /**
     *      Поулчить настройки подключения к БД
     *
     * @return array
     */
    public function getSetups()
    {
        return $this->setups;
    }

    /**
     * @return PDO|null
     */
    public static function getConnect()
    {
        $resp = null;

        if ( App::$db->connection ) $resp = App::$db->connection;

        $setups = App::$db->getSetups();

        if ( ! $resp )
        {
            if ( $setups )
            {
                try
                {
                    $resp = new PDO( $setups['dsn'], $setups['username'], $setups['password'] );

                } catch ( PDOException $e ) {

                    self::exception( 'PDO Exception: ' . $e->getMessage() );
                }

            } else {

                self::exception( 'DB Setups `empty`' );
            }
        }

        return $resp;
    }

    /**
     *      ППроверка наличия соединения с БД
     */
    public function checkConnect()
    {
        if ( ! $this->connection )
        {
            $this->connection = App::$db::getConnect();
        }
    }

    /**
     * @param string $sql
     * @return false|PDOStatement
     */
    public static function query( $sql )
    {
        $result = self::getConnect()->query( $sql );

        return $result;
    }

    /**
     * @return false|PDOStatement
     * P.S. GameDevTime_ VIP до 09.07
     */
    public static function getTables()
    {
        $sql = "SELECT * FROM `migrations`";

        $tables = static::query( $sql );

        self::printPre($tables);

        return $tables;
    }
}