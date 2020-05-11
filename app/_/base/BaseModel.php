<?php

namespace _\base;

use _\components\DB;
use _\components\Query;
use PDO;

/**
 * Class BaseModel
 * @package app\_\base
 */
class BaseModel extends Query
{
    /**
     *      Библиотека аттрибутов (новых/изменённых)
     *
     * @var array
     */
    private $_data      = [];

    /**
     *      Библиотека аттрибутов
     *
     * @var array
     */
    private $_oldData   = [];

    /**
     *      Библиотека аттрибутов
     *
     * @var array
     */
    public $labels      = [];

    public $isNewRecord = false;

    /**
     * @param $name
     * @param $value
     */
    function __set( $name, $value )
    {
        $this->_data[ $name ] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    function __get( $name )
    {
        if ( isset($this->_data[ $name ]) )
        {
            return $this->_data[ $name ];

        } else {

            self::exception("Object" . self::getClassName() . " dont has property {$name}");
        }
    }

    /**
     *      BaseModel constructor.
     *
     * @param array|object $params
     */
    function __construct( $params = [] )
    {
        parent::__construct([]);

        $this->isNewRecord = true;

        if ( !empty($params) )
        {
            $this->_oldData = $params;
            $this->_data    = $params;
        }
    }

    /**
     *      получение одной записи
     *
     * @return static
     */
    public function one()
    {
        $result = $this->request();

        $resp = $result->fetch(PDO::FETCH_ASSOC );

        $isArray        = $this->getProps('arrayValues');
        $arrayValues    = $this->getProps('isArray');

        if ( ! $arrayValues AND ! $isArray )
        {
            $resp = new static( (array) $resp );
            $resp->isNewRecord = false;

            if ( $this->selectHasNotID() ) unset($resp->_data['id']);

        } else {

            if ( $this->selectHasNotID() ) unset($resp['id']);

            if ( $arrayValues )
            {
                $resp = (array) $resp;
                $resp = $resp[0];
            }

            if ( ! $isArray )
            {
                $resp = (object) $resp;
            }
        }

        return  $resp;
    }

    /**
     *      получение мнодества записей
     *
     * @return static[]
     */
    public function all()
    {
        $result = $this->request();

        $resp = $result->fetchAll(PDO::FETCH_CLASS );

        $isArray        = $this->getProps('isArray');
        $arrayValues    = $this->getProps('arrayValues');

        if ( $this->selectHasNotID() )
        {
            $resp = array_map(function ( $obj )
            {
                unset($obj->id);

                return $obj;

            }, $resp );
        }

        if ( ! $arrayValues AND ! $isArray )
        {
            $resp = array_map(function ( $obj )
            {
                $model = new static( (array) $obj );
                $model->isNewRecord = false;

                return $model;

            }, $resp );

        } else {

            if ( $arrayValues )
            {
                $resp = array_map(function ($obj)
                {
                    $obj    = (array) $obj;
                    $obj    = array_values( $obj );

                    return ( count($obj) == 1 ) ? array_shift($obj ) : $obj;

                }, $resp );
            }

            if ( $isArray )
            {
                $resp = array_map(function ( $obj )
                {
                    return (array) $obj;

                }, $resp );
            }
        }

        return  $resp;
    }

    /**
     * @return self
     */
    public static function createModel()
    {
        return new static();
    }

    /**
     * @return self
     */
    public static function get()
    {
        $model = static::createModel();

        return $model;
    }

    /**
     * @param array $where
     * @return static[]
     */
    public static function getAll( $where = [] )
    {
        $model  = static::createModel();

        $models = $model->where( $where )->all();

        return $models;
    }

    /**
     * @param array $data
     * @return self
     */
    public function insert( $data = [] )
    {
        foreach ( $data as $key => $value )
        {
            $this->{$key} = $value;
        }

        return $this->save();
    }

    /**
     * @param array $data
     */
    public function update( $data = [] )
    {
        $this->_data = array_merge( $this->_data, $data );
    }

    /**
     * @return self
     */
    public function save()
    {
        if ( $this->isNewRecord )
        {
            $cols   = array_keys( $this->_data );
            $cols   = array_map(function ($columnName)
            {
                return "`{$columnName}`";
            }, $cols );

            $vals   = array_values( $this->_data );
            $vals   = array_map(function ($value)
            {
                return ( is_integer($value) ) ? $value : "'{$value}'";
            }, $vals );

            $SQL    = "INSERT INTO `{$this->tableName}` ("
               . implode(', ', $cols )
               . ') VALUES ( '
               . implode(', ', $vals ) . ');';

        } else {

            $SQL    = "UPDATE `{$this->tableName}` SET ";

            foreach ( $this->_data as $column => $value )
            {
                if ( $this->_data[ $column ] == $this->_oldData[ $column ] ) continue;

                $SQL    .= "`{$column}` = " . (( is_integer($value) ) ? $value : "'$value', ");
            }

            $SQL    = trim( $SQL, ', ') . ' WHERE ';

            $SQL .= " `id` = " . $this->_oldData['id'];
        }

        if ( DB::query( $SQL ) )
        {
            $this->_oldData = array_merge( $this->_oldData, $this->_data );
        };

        return $this;
    }

    /**
     *
     */
    public function delete()
    {

    }
}