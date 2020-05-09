<?php

namespace _\components;

use _\base\Core;

/**
 * Class Record
 *
 * @package app\_\components
 */
class Record extends Query
{
    private $tableName   = '';


    /**
     * @return $this
     */
    public function one()
    {
        $params = parent::one();

        $model  = $this->createModel( $params );

        return $model;
    }

    /**
     * @return $this[]
     */
    public function all()
    {
        $resp = [];

        foreach ( parent::all() as $params )
        {
            $resp[] = $this->createModel( $params );
        }

        return $resp;
    }

    /**
     * @param $params
     * @return $this
     */
    private function createModel( $params )
    {
        $model = new static();

        foreach ( $params as $key => $value )
        {
            $model->{$key} = $value;
        }

        return $model;
    }
}