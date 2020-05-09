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
    private $tableName  = '';

    private $select     = [];
    private $where      = [];
    private $andWhere   = [];
    private $leftJoin   = [];
    private $order      = [];
    private $limit      = 1;

    private $isArray    = false;

    private $rawSql     = '';

    private $result     = '';

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
     *      получение одной записи
     *
     * @return string
     */
    public function one()
    {
        $result = $this->request();

        $resp = $result->fetch(PDO::FETCH_ASSOC );

        if ( ! $this->isArray )
        {
            $resp = (object) $resp;
        }

        return  $resp;
    }

    /**
     *      получение мнодества записей
     *
     * @return array
     */
    public function all()
    {
        $result = $this->request();

        $resp = $result->fetchAll(PDO::FETCH_CLASS );

        if ( $this->isArray )
        {
            $func = function ( $obj )
            {
                return (array) $obj;
            };

            $resp = array_map( $func, $resp );
        }

        return  $resp;
    }

    /**
     *      Выполнение запроса
     *
     * @return false|PDOStatement
     */
    public function request()
    {
        $this->rawSql = $this->getSql();

        $this->result = $this->query( $this->rawSql );

        return $this->result;
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

        return trim( $sql );
    }

    /**
     * @return string
     */
    private function getSelect()
    {
        return implode(',', $this->select );
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

            foreach ( $this->where as $params )
            {
                $where .= $this->whereConstruct( $params );
            }

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
            case 2:
                list( $column, $value ) = $params;

                $resp   .= "`{$column}` ";
                break;

            case 3:
                list( $column, $conditions, $value ) = $params;

                $resp   .= "`{$column}` {$conditions}";
                break;

            default:
                return '';
        }

        if ( is_array($value) )
        {
            $resp   .=" IN (" . implode( ',', $value ) . ")";

        } elseif ( is_string($value) ) {

            $resp   .=" = '{$value}' ";

        } elseif ( is_integer($value) ) {

            $resp   .=" = {$value} ";
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
        $resp = [];

        if ( count( $this->leftJoin ) )
        {
            foreach ( $this->leftJoin as $joinLeft )
            {
                $tableName  = $joinLeft[0];
                $sql        = $joinLeft[1];
                $resp[] = "LEFT JOIN `{$tableName}` {$sql}";
            }

            $resp = implode( ', ', $resp );
        }

        return $resp;
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