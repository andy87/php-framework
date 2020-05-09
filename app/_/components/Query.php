<?php

namespace _\components;

use _\base\Core;
use PDO;
use PDOStatement;

/**
 * Class Query
 *
 * @package app\_\components
 */
class Query extends DB
{
    public $tableName  = '';

    private $select     = '*';
    private $where      = [];
    private $andWhere   = [];
    private $leftJoin   = [];
    private $order      = [];
    private $limit      = 0;

    private $isArray        = false;

    /** @var bool метка возвращать только значения */
    private $arrayValues    = false;

    private $rawSql     = '';

    /**
     *      Поулчение экранированного имени таблицы
     *
     * @return string
     */
    public function getTableName()
    {
        return "`{$this->tableName}`";
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getProps( $key )
    {
        return $this->{$key};
    }

    /**
     * @return $this
     */
    public function find()
    {
        return $this;
    }

    /**
     * @param string|array $columns
     *
     * @return $this
     */
    public function select( $columns = '' )
    {
        if ( $select = $this->normalizeParams( $columns ) )
        {
            $this->select = $select;
        }

        return $this;
    }

    /**
     *      Вернуть объекты как массив
     */
    public function asArray()
    {
        $this->isArray = true;

        return $this;
    }

    /**
     *      Вернуть значения полей
     *
     * @return $this
     */
    public function asArrayValues()
    {
        $this->isArray      = false;
        $this->arrayValues  = true;

        return $this;
    }

    /**
     * @param $condition
     * @return $this
     */
    public function where( $condition )
    {
        $this->where = $condition;

        return $this;
    }

    /**
     * @param $condition
     * @return $this
     */
    public function andWhere( $condition )
    {
        $this->andWhere[] = $condition;

        return $this;
    }

    /**
     * @param string|array $columns
     * @return $this
     */
    public function orderBy( $columns = '' )
    {
        if ( $order = $this->normalizeParams( $columns ) )
        {
            $this->order = $order;
        }

        return $this;
    }

    /**
     *
     */
    public function selectHasNotID()
    {
        $resp = ( is_string( $this->select ) && strpos( $this->select, '*' ) === false );

        if ( !$resp ) $resp = ( is_array( $this->select ) && in_array( 'id', $this->select ) === false  );

        return $resp;
    }

    /**
     *      Выполнение запроса
     *
     * @return false|PDOStatement
     */
    public function request()
    {
        $this->getSql();

        $result = $this->query( $this->rawSql );

        return $result;
    }

    /**
     *      Сборка SQL по имеющимся данным
     */
    public function getSql()
    {
        $sql = implode(' ', [
            'SELECT',
            $this->getSelect(),
            'FROM',
            $this->getTableName(),
            $this->sqlPartWhere(),
            $this->sqlPartLeftJoin(),
            $this->sqlPartLimit(),
            $this->sqlPartOrder()
        ]);

        $this->rawSql = trim( $sql );
    }

    /**
     * @return string
     */
    private function getSelect()
    {
        $select = $this->select;

        if ( is_array($select) )
        {
            if ( ! in_array('id', $select) ) $select[] = 'id';

            $select = implode(',', $select );
        }

        return $select;
    }

    /**
     * @return string
     */
    private function sqlPartWhere()
    {
        $where = '';

        if ( count( $this->where ) )
        {
            $where = ' WHERE';

            $where .= $this->whereConstruct( $this->where );

            if ( count( $this->andWhere ) )
            {
                $where .= ' AND WHERE';

                foreach ( $this->where as $params )
                {
                    $where .= $this->whereConstruct( $params );
                }
            }
        }

        return $where;
    }

    /**
     *      Обработчик условий Where
     *
     * @param array $params
     * @return string
     */
    private function whereConstruct( $params )
    {
        $resp = ' ';


        switch ( count($params) )
        {
            // если 2 знаения в where([$column, $value])
            case 2:
                list( $column, $value ) = $params;
                $resp      .= "`{$column}` ";
                $conditions = '=';
                break;

            // если 3 знаения в where([$column, $conditions, $value])
            case 3:
                list( $column, $conditions, $value ) = $params;
                $resp   .= "`{$column}`";
                break;

            default:
                return '';
        }

        if ( is_array($value) )
        {
            $resp   .=" IN (" . implode( ',', $value ) . ")";

        } elseif ( is_string($value) ) {

            $resp   .=" {$conditions} '{$value}' ";

        } elseif ( is_integer($value) ) {

            $resp   .=" {$conditions} {$value} ";
        }

        return $resp;
    }

    /**
     *      Возвращает часть кода Left Join
     *
     * @return string
     */
    private function sqlPartLeftJoin()
    {
        if ( count( $this->leftJoin ) )
        {
            $resp = [];

            foreach ( $this->leftJoin as $joinLeft )
            {
                $tableName  = $joinLeft[0];
                $sql        = $joinLeft[1];
                $resp[] = "LEFT JOIN `{$tableName}` {$sql}";
            }

            return implode( ', ', $resp );
        }

        return '';
    }

    /**
     * @return string
     */
    private function sqlPartLimit()
    {
        return ( $this->limit ) ? "LIMIT {$this->limit}" : '';
    }

    /**
     * @return string
     */
    private function sqlPartOrder()
    {
        return  ( $this->order ) ? "ORDER BY {$this->order}" : '';
    }

    /**
     * @param string $item
     * @return array|null
     */
    private function normalizeParams( $item = '' )
    {
        if ( ! is_array( $item ) && ! is_string( $item ) ) return null;

        return ( is_string( $item ) ) ? [$item] : $item;
    }
}