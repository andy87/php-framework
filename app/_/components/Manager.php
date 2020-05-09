<?php

namespace _\components;

//TODO: нечем было заняться? Вот тебе миграции делай!
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
     *      Создатель SQL создания таблицы
     *
     * @param array $tableMap
     */
    public function tableCreate( $tableMap = self::TABLE_TEMPLATE )
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


        $SQL = "CREATE TABLE {$this->tableName}\r\n({$columns}\r\n);";

        try
        {
            $this->query($SQL)->execute();

            echo " Manager: table `{$this->tableName}` created";

        } catch ( \Exception $e ) {

            echo " Manager: table `{$this->tableName}` error \r\n\t" . $e->getMessage();
        }
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
    public function id()
    {
        return $this->integer(7)->notNull()->autoincrement( "{$this->tableName}_pk" );
    }

}