<?php

namespace migrations;

use _\components\Manager;

/**
 *      Model: user
 *
 * @package models
 */
class m200511_110454_user extends Manager
{
    public $tableName       = 'user';
    public $tableComment    = 'Пользователи';

    /**
    *   Comment Up
    */
    public function up()
    {
        $this->tableCreate([
            'id'            => $this->pk(),
            'status'        => $this->integer(2)->notNull(),
            'username'      => $this->string(64)->notNull(),
            'email'         => $this->string(64)->notNull(),
            'passHash'      => $this->string(32)->notNull(),
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
