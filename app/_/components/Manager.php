<?php

namespace _\components;

use _\models\Migration;

/**
 *      Родительский клас для миграций
 *
 * @package app\_\components
 *
 * @method Column string($length)
 * @method Column integer($length)
 * @method Column datetime()
 * @method Column timestamp()
 * @method Column text()
 */
class Manager extends DB
{
    const TABLE_TEMPLATE   = [];

    /**
     *      Имя таблицы
     *
     * @var string
     */
    public $tableName       = '';

    /**
     *      Комментарий к таблице
     *
     * @var string
     */
    public $tableComment    = '';

    /**
     *      SQL код таблицы
     *
     * @var string
     */
    public  $rawSql         = '';

    /**
     *      Генерация колонок
     *          Используется для вызовов методов: string, integer, datetime, timestamp, text
     *
     * @param string $name
     * @param integer $arguments
     * @return void|null
     */
    function __call( $name, $arguments )
    {
        if ( method_exists( Column::class, $name ) )
        {
            $column = new Column();
            $params = $arguments[0];
            return ( $arguments ) ? $column->{$name}( $params ) : $column->{$name}();
        }

        return null;
    }

    /**
     *      Создание таблицы
     *
     * @param array $tableMap
     * @return false|\PDOStatement
     */
    public function tableCreate( $tableMap = self::TABLE_TEMPLATE )
    {
        $this->generateSql( $tableMap );

        if ( $result = $this->query( $this->rawSql ) )
        {
            echo "\r\n - table `{$this->tableName}` created";

            Migration::add( $this->getClassName() );

        } else {

            echo "\r\n - table `{$this->tableName}` SQL error\r\n\t";
        }

        return $result;
    }

    /**
     *      Генерация SQL кода таблицы
     *
     * @param array $tableMap
     * @return string
     */
    private function generateSql( $tableMap )
    {
        $columns            = '';
        $autoincrement      = null;
        $this->tableName    = self::setupSnakeCase($this->tableName);

        /**
         * @var $columnObject Column
         */
        foreach ( $tableMap as $columnName => $columnObject )
        {
            // пробелы для стильного SQL кода в пременной $SQL
            $columnParams = $columnObject->generate();
            $columns .= "\r\n    `{$columnName}` {$columnParams},";

            if ( $columnObject->autoincrement )
            {
                $autoincrement = "\r\n    CONSTRAINT {$this->tableName}_pk PRIMARY KEY ({$columnName})";
            }
        }

        if ( $autoincrement ) $columns .= $autoincrement;

        $columns = trim($columns, ',');

        return $this->rawSql = "CREATE TABLE {$this->tableName}\r\n({$columns}\r\n);";
    }

    /**
     *      Пользовательский метод
     */
    public function up() {}

    /**
     *      Пользовательский метод
     */
    public function down() {}

    /**
     *      Пользовательский метод
     */
    public function demo()
    {
        return [];
    }

    /**
     *      Обработчик demo() заливающий тестовые данные в БД
     *
     * @param array $params
     */
    public function fill( $params = [] )
    {
        // ...
    }

    /**
     *
     */
    public function dropTable()
    {
        // ...
    }

    /**
     * @return Column
     */
    public function pk()
    {
        return $this->integer(7)->notNull()->autoincrement( "{$this->tableName}_pk" );
    }

}