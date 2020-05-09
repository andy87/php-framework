<?php

namespace migrations;

use _\components\Manager;

/**
 *      Model: Migration
 *
 * @package models
 */
class m_000000_000000_Init extends Manager
{
    public $tableName       = 'migrations';
    public $tableComment    = 'таблица миграций';

    /**
    *   Comment Up
    */
    public function up()
    {
        $tableMap = [
            'name'          => $this->string( 128 ),
            'timestamp'     => $this->integer( 11 ),
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
