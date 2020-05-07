<?php

namespace _\components;

use _\base\Core;

/**
 * Class Query
 * @package app\_\components
 */
class Query extends Core
{
    public $tableName   = '';


    private $where      = [];
    private $limit      = 1;
    private $order      = '';
    private $rawSql     = '';
    private $resp       = '';


    /**
     * @return $this
     */
    public function find()
    {
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
     * @param $orderBy
     * @return $this
     */
    public function orderBy($orderBy)
    {
        $this->order = $orderBy;

        return $this;
    }

    /**
     * @return string
     */
    public function one()
    {
        $this->select();

        // получение одной записи

        return $this->resp;
    }

    /**
     * @return string
     */
    public function all()
    {
        $this->limit = 0;

        $this->select();

        // получение всех записей

        return $this->resp;
    }

    /**
     *
     */
    public function select()
    {
        $WHERE = '';
        if ( count($this->where) )
        {
            $WHERE = ' WHERE';
            foreach ( $this->where as $key => $value )
            {
                $WHERE .= "`{$key}` " . (
                    ( is_array($value) )
                        ? " IN (" . implode(',', $value) . ")"
                        : " = {$value}"
                    );
            }

        }
        $LIMIT = ( $this->limit ) ? "LIMIT {$this->limit}" : '';
        $ORDER = ( $this->order ) ? "ORDER BY {$this->order}" : '';

        $this->rawSql = "SELECT {$this->select} FROM {$this->tableName} {$WHERE} {$LIMIT} {$ORDER}";

        // exec ( $this->rawSql );
    }
}