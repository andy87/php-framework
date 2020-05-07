<?php

namespace migrations;

use _\components\Migration;

/**
 *      Model: {{$migrationName}}
 *
 * @package models
 */
class {{$migrationClass}} extends Migration
{
    public $tableName       = '{{$tableName}}';
    public $tableComment    = '{{$tableComment}}';

    /**
    *   Comment Up
    */
    public function up()
    {
        $this->tableCreate([
            'id'            => $this->id(),
            'status'        => $this->integer(2),
            // you columns
            'created_at'    => $this->integer(2),
            'updated_at'    => $this->integer(2),
        ]);
    }

    /**
    *    Comment Down
    */
    public function down()
    {
        $this->dropTable( $this->tableName );
    }
}
