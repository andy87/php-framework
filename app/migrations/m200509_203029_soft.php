<?php

namespace migrations;

use _\components\Manager;

/**
 *      Model: soft
 *
 * @package models
 */
class m200509_203029_soft extends Manager
{
    public $tableName       = 'table_soft';
    public $tableComment    = '';

    /**
    *   Comment Up
    */
    public function up()
    {
        $this->tableCreate([
            'id'            => $this->pk(),
            'status'        => $this->integer(2),
            'soft_name'     => $this->string(255),
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
