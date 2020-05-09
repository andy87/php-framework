<?php

namespace migrations;

use _\components\Manager;

/**
 *      Model: skill
 *
 * @package models
 */
class m200509_203019_skill extends Manager
{
    public $tableName       = 'table_skill';
    public $tableComment    = '';

    /**
    *   Comment Up
    */
    public function up()
    {
        $this->tableCreate([
            'id'            => $this->pk(),
            'status'        => $this->integer(2),
            'skill_name'    => $this->string(64),
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
