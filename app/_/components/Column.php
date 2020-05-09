<?php

namespace _\components;

use _\base\Core;

/**
 *      Клас для генерации описания колонок к БД
 *
 * @package app\_\components
 */
class Column extends Core
{
    const TYPE_VARCHAR      = 1;
    const TYPE_INTEGER      = 2;
    const TYPE_DATETIME     = 3;
    const TYPE_TIMESTAMP    = 4;
    const TYPE_TEXT         = 5;

    private $mapping = [
        1 => 'VARCHAR',
        2 => 'INTEGER',
        3 => 'DATETIME',
        4 => 'INTEGER',
        5 => 'TEXT',
    ];

    private $type           = null;
    private $length         = null;
    private $defaultValue   = null;
    private $comment        = null;
    private $notNull        = null;
    public  $autoincrement  = null;

    /**
     * @param int $length
     * @return $this
     */
    public function string( $length = 255 )
    {
        $this->type     = self::TYPE_VARCHAR;
        $this->length   = $length;

        return $this;
    }

    /**
     * @param int $length
     * @return $this
     */
    public function integer( $length = 11 )
    {
        $this->type     = self::TYPE_INTEGER;
        $this->length   = $length;

        return $this;
    }

    /**
     * @return $this
     */
    public function datetime()
    {
        $this->type     = self::TYPE_DATETIME;

        return $this;
    }

    /**
     * @return $this
     */
    public function timestamp()
    {
        $this->type     = self::TYPE_TIMESTAMP;
        $this->length   = 14;

        return $this;
    }

    /**
     * @return $this
     */
    public function text()
    {
        $this->type = self::TYPE_TEXT;

        return $this;
    }

    /**
     * @return $this
     */
    public function notNull()
    {
        $this->notNull = true;

        return $this;
    }

    /**
     * @param $str
     * @return $this
     */
    public function comment( $str )
    {
        $this->comment = $str;

        return $this;
    }

    /**
     * @param string|integer $value
     * @return $this
     */
    public function default( $value )
    {
        $this->defaultValue = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function autoincrement( $key = '' )
    {
        $this->autoincrement = $key;

        return $this;
    }

    /**
     *      Генератор свойств табличной колонки
     *
     * @return mixed|string
     */
    public function generate()
    {
        $sql    = $this->mapping[ $this->type ];

        if ( $this->length )        $sql .= "({$this->length}) ";

        $sql   .= ( $this->notNull )  ? " NOT NULL " : '';

        if ( $this->defaultValue )
        {
            if ( is_string($this->defaultValue) ) $this->defaultValue = "'{$this->defaultValue}'";

            $sql .= " DEFAULT {$this->defaultValue} ";
        }

        if ( $this->comment )       $sql .= " COMMENT '{$this->comment}' ";

        if ( $this->autoincrement ) $sql .= " AUTO_INCREMENT ";

        $sql    = trim(str_replace('  ', ' ', $sql ));

        return  $sql;
    }

}