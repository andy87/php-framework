<?php

namespace models\source;

use _\components\Query;

/**
 *      Model: {{$modelName}}
 *
 * @package models
 */
class {{$modelName}} extends Query
{
    public $tableName = '{{$modelTableName}}';

    public function validation()
    {
        return {{$validation}};
    }

    public function rules()
    {
        return {{$rules}};
    }

}
