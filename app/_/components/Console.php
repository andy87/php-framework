<?php

namespace _\components;

use _\base\Core;
use _\models\Migration;

/**
 *      Общий клас для некоторых хелперов
 *
 * @package app\_\components
 */
class Console extends Core
{
    const ACTION_CREATE     = 'create';
    const ACTION_MIGRATE    = 'migrate';
    const ACTION_BD         = 'db';

    const ACTION_NOT_FOUND  = 'Console `action` not found';

    public $models      = [
        'create'            => 'Generator',
        'migrate'           => 'Migration',
        'db'                => 'DB',
    ];

    public $params      = '';

    public $action      = '';
    public $method      = '';

    public $error       = false;

    public $arguments   = [];

    public $response;


    /**
     * Console constructor.
     *
     * @param array $params
     */
    function __construct($params = [])
    {
        parent::__construct($params);

        $this->params = $params;

        $this->action = $params[1];

        if ( strpos($params[1], SLASH) !== false )
        {
            $actionData     = explode( SLASH, $params[1]);

            $this->action   = $actionData[0];
            $this->method   = $actionData[1];
        }
    }

    /**
     * @param string $type
     * @param string|bool $path
     */
    public function setStatus( $type, $path )
    {
        $this->response = ( "Generate `{$type}` "
            . ( ( $path )
                ? "complete. File: {$path}"
                : "error."
            ) );
    }

    /**
     * @param $generator Generator
     */
    public function generateController( $generator )
    {
        if ( !isset($this->params[2]) ) $this->params[2] = false;

        list( $path, $action, $controllerName ) = $this->params;

        if ( ! $controllerName )
        {
            $this->error = "Generate `controller` error: empty `controller name` "
                . "\r\n Example: _ create/controller Test";

        } else {

            $path = $generator->generateController( $controllerName );

            $this->setStatus( 'controller', $path );
        }
    }

    /**
     * @param $generator Generator
     */
    public function generateModel( $generator )
    {
        if ( !isset($this->params[2]) ) $this->params[2] = false;
        if ( !isset($this->params[3]) ) $this->params[3] = false;

        list( $path, $action, $modelName, $tableName ) = $this->params;

        if ( ! $modelName || ! $tableName )
        {
            $this->error    = 'Generate `model` error: not found ';
            if ( ! $modelName ) $this->error .= '`model name`';
            if ( ! $modelName && ! $tableName ) $this->error .= ' AND ';
            if ( ! $tableName ) $this->error .= '`table name`';
            $this->error   .= "\r\nExample: _ create/model Car table_car";

        } else {

            $path = $generator->generateModel( $modelName, $tableName );

            $this->setStatus( 'model', $path );
        }
    }

    /**
     * @param $generator Generator
     */
    public function generateModule( $generator )
    {
        if ( !isset($this->params[2]) ) $this->params[2] = false;
        list( $path, $action, $moduleName ) = $this->params;

        if ( !$moduleName )
        {
            $this->error = "Generate `module` error: empty `module name` "
                . "\r\n Example: _ create/module Vendor";
        } else {

            $path = $generator->generateModule( $moduleName );

            $this->setStatus( 'module', $path );
        }
    }

    /**
     * @param $generator Generator
     */
    public function generateMigration( $generator )
    {
        if ( !isset($this->params[2]) ) $this->params[2] = false;
        if ( !isset($this->params[3]) ) $this->params[3] = '';
        if ( !isset($this->params[4]) ) $this->params[4] = '';

        list( $path, $action, $migrationName, $tableName, $tableComment ) = $this->params;

        if ( ! $migrationName )
        {
            $this->error    = 'Generate `migration` error: not found ';
            if ( ! $migrationName ) $this->error .= '`migration name`';
            $this->error   .= "\r\nExample: _ create/migration Profile";
            $this->error   .= "\r\nExample 2: _ create/migration Profile table_user 'table comment'";

        } else {

            $path = $generator->generateMigration( $migrationName, $tableName, $tableComment );

            $this->setStatus( 'migration', $path );
        }
    }

    /**
     * @param $generator Generator
     */
    public function generateView( $generator )
    {
        if ( !isset($this->params[2]) ) $this->params[2] = false;
        if ( !isset($this->params[3]) ) $this->params[3] = false;

        list( $path, $action, $controllerName, $viewName ) = $this->params;

        if ( ! $controllerName || ! $viewName )
        {
            $this->error    = 'Generate `view` error: not found ';
            if ( ! $controllerName ) $this->error .= '`controller name`';
            if ( ! $controllerName && ! $viewName ) $this->error .= ' AND ';
            if ( ! $viewName ) $this->error .= '`action name`';
            $this->error   .= "\r\nExample: _ create/view Car show";

        } else {

            $path = $generator->generateView( $controllerName, $viewName );

            $this->setStatus( 'view', $path );
        }
    }

    public function migratePending()
    {
        $migration = Migration::getPendingList();

        $this->response = "Migration pending list:\r\n"
            . ( ( ! count( $migration ) )
                ? "empty"
                : ' - ' . implode("\r\n - ", $migration )
            );
    }

    /**
     *      Выводим текст информации о результате рендера
     */
    public function response()
    {
        echo ( ( is_string($this->error) )
                ? $this->error
                : $this->response
            ) . RN;

        exit();
    }

    /**
     *      Задать error из вне
     *
     * @param $error
     */
    public function setError( $error )
    {
        $this->error = $error;
    }
}