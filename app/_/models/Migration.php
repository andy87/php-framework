<?php

namespace _\models;

use _\base\BaseModel;
use _\components\DB;
use _\components\Manager;

/**
 * Class Migration
 * @package _\models
 *
 * @property integer $id
 * @property string $name
 * @property integer $timestamp
 */
class Migration extends BaseModel
{
    /** @var string Имя таблицы */
    public $tableName = 'migrations';

    /**
     *      Получить список незарегистрированых миграций
     *
     * @return array
     */
    public static function getPendingList()
    {
        $migrationList = array_map(function ( $path )
        {
            $data   = pathinfo( $path );

            return  $data['filename'];

        }, self::getFileList() );

        $migrationComplete  = self::getExistsList();

        $migrations         = array_diff( $migrationList, $migrationComplete );

        return $migrations;
    }

    /**
     *      Проводит миграцию в БД
     */
    public static function upgrade()
    {
        echo  "Migrations:";

        $tables = DB::getTables();

        foreach ( self::getPendingList() as $migrationName )
        {
            $migrationClass = 'migrations\\' . $migrationName;

            /** @var Manager $migration */
            $migration      = new $migrationClass();

            try
            {
                if ( !in_array( $migration->tableName, $tables ) )
                {
                    // создаём таблицу
                    $migration->up();

                    // заполняем таблицу тестовыми данными
                    if ( count( $demo = $migration->demo() ) )
                    {
                        $migration->fill( $demo );
                    }

                } else {

                    echo "\r\n - table `{$migration->tableName}` exist!";
                }

            } catch (\Exception $e ) {

                echo "\r\nMigrate upgrade error : " . $e->getMessage();
            }
        }
    }

    /**
     *   Возвращает список файлов в папке `app/migrations/`
     *
     * @return array|false
     */
    public static function getFileList()
    {
        $list = glob( DIR_MIGRATIONS . '*.php' );

        $func = function ( $item )
        {
            return self::slashReplace( $item );
        };

        $list = array_map( $func, $list );

        return $list;
    }

    /**
     *      ВЫозвращает список выполненых миграций
     *
     * @return array
     */
    public static function getExistsList()
    {
        $result = self::get()->select('name')->asArrayValues()->all();

        return  $result;
    }

    /**
     * @param $migrationName
     * @return Migration|null
     */
    public static function add( $migrationName )
    {
        $model = new static();

        $model->insert([
            'name'      => $migrationName,
            'timestamp' => time()
        ]);

        return ( $model ) ? $model : null;
    }
}