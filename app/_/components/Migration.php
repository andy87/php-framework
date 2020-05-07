<?php

namespace _\components;

use _\base\Core;

//TODO: нечем было заняться? Вот тебе миграции делай!
/**
 *      Родительский клас для миграций
 *
 * @package app\_\components
 */
class Migration extends Core
{
    public $tableName       = '';
    public $tableComment    = '';

    public function up()
    {
        // ...
    }

    public function down()
    {
        // ...
    }

}