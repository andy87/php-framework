<?php

namespace migrations;

use _\components\Manager;

/**
 *      Model: Migration
 *
 * @package models
 */
class m000000_000000_Init extends Manager
{
    public $tableName       = 'migrations';
    public $tableComment    = 'таблица миграций';

    /**
    *   Comment Up
    */
    public function up()
    {
        $tableMap = [
            'id'            => $this->pk(),
            'name'          => $this->string( 128 )->notNull(),
            'timestamp'     => $this->timestamp()->notNull(),
        ];

        $this->tableCreate($tableMap);
    }

    /**
    *    Comment Down
    */
    public function down()
    {
        $this->dropTable( $this->tableName );
    }
}
