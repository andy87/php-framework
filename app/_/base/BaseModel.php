<?php

namespace _\base;

use _\components\DB;
use _\components\Query;

/**
 * Class BaseModel
 * @package app\_\base
 */
class BaseModel extends Query
{
    public $data    = [];

    public $labels  = [];


    /**
     * @return BaseModel
     */
    public static function createModel()
    {
        return new self();
    }

    /**
     * @return BaseModel
     */
    public static function get()
    {
        $model = self::createModel();

        return $model;
    }

    /**
     * @param array $where
     * @return BaseModel
     */
    public static function getAll( $where )
    {
        $model = self::createModel();

        $model->where( $where )->all();

        return $model;
    }

    /**
     * @return $this
     */
    public function asArray()
    {
        $this->asArrey = true;

        return $this;
    }

    public function one()
    {

    }

    public function all()
    {

    }

    /**
     * @param array $insert
     * @return array
     */
    public function insert( $insert = [] )
    {
        $this->data = $insert;

        return $this->save();
    }

    /**
     * @param array $data
     */
    public function update( $data = [] )
    {
        $this->data = array_merge( $this->data, $data );
    }

    /**
     * @return BaseModel
     */
    public function save()
    {
        $SQL    = '';

        $result = DB::query( $SQL );

        return $this;
    }

    /**
     *
     */
    public function delete()
    {

    }
}