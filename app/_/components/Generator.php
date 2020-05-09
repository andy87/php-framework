<?php

namespace _\components;

use _\base\Core;
use _\helpers\File;


/**
 *      Клас для консольных комманд генерации
 */
class Generator extends Core
{
    const ID_CONTROLLER     = 'controller';
    const ID_MODEL          = 'model';
    const ID_MODULE         = 'module';
    const ID_MIGRATION      = 'migration';
    const ID_VIEW           = 'view';

    const TPL_CONTROLLER    = DIR_TEMPLATES . 'generator/controller.tpl';
    const TPL_MODEL         = DIR_TEMPLATES . 'generator/model.tpl';
    const TPL_MODEL_SOURCE  = DIR_TEMPLATES . 'generator/model-source.tpl';
    const TPL_MODULE        = DIR_TEMPLATES . 'generator/module.tpl';
    const TPL_MIGRATION     = DIR_TEMPLATES . 'generator/migration.tpl';
    const TPL_VIEW          = DIR_TEMPLATES . 'generator/view.tpl';

    const DIR_CONTROLLER    = DIR_APP . '/controllers/';
    const DIR_MODEL         = DIR_APP . '/models/';
    const DIR_MODEL_SOURCE  = DIR_APP . '/models/source/';
    const DIR_MODULE        = DIR_APP . '/modules/';
    const DIR_MIGRATION     = DIR_APP . '/migrations/';
    const DIR_VIEW          = DIR_APP . '/views/';

    /**
     *      Генерация `Controller` по шаблону `app/_/templates/generator/controller`
     *
     *          php _ create/controller name
     *
     * @param $controllerName
     * @return bool
     */
    public function generateController( $controllerName )
    {
        $controllerName = self::setupCamelCase($controllerName);

        $path       = self::DIR_CONTROLLER . $controllerName . CONTROLLER_SUFFIX . PHP;
        $path       = self::slashReplace($path);

        $params     = [
            'controllerName' => $controllerName
        ];

        $content    = File::generateContent( self::TPL_CONTROLLER, $params );

        return ( File::generateFile( $path, $content ) ) ? $path : null;
    }

    /**
     *      Генерация `View` по шаблону `app/_/templates/generator/view`
     *
     *          php _ create/view name name
     *
     * @param $controller
     * @param $view
     * @return bool
     */
    public function generateView( $controller, $view )
    {
        $controller = self::setupKebabCase( $controller );
        $view       = self::setupKebabCase( $view );

        $path       = self::DIR_VIEW . $controller . SLASH . $view . PHP;
        $path       = self::slashReplace($path);

        $content    = File::generateContent( self::TPL_VIEW, [] );

        $dirController = self::DIR_VIEW . $controller;

        if ( ! is_dir( $dirController ) ) mkdir($dirController);

        return ( File::generateFile( $path, $content ) ) ? $path : null;
    }

    /**
     *      Генерация `Module` по шаблону `app/_/templates/generator/module`
     *
     *          php _ create/module name
     *
     * @param $moduleName
     * @return bool
     */
    public function generateModule( $moduleName )
    {
        $moduleName = self::setupCamelCase($moduleName);
        $path       = self::DIR_MODULE . $moduleName . PHP;
        $path       = self::slashReplace($path);

        $params     = [
            'moduleName' => $moduleName
        ];

        $content    = File::generateContent( self::TPL_MODULE, $params );

        return ( File::generateFile( $path, $content ) ) ? $path : null;
    }

    /**
     *      Генерация `Model` по шаблону `app/_/templates/generator/model`
     *
     *          php _ create/model name
     *
     * @param $modelName
     * @return bool
     */
    public function generateModel( $modelName, $tableName )
    {
        $modelName      = self::setupCamelCase( $modelName );
        $tableName      = self::setupSnakeCase( $tableName );

        $modelTableName = $tableName;

        $validation     = '[]'; //TODO: доделать
        $rules          = '[]'; //TODO: доделать

        $params         = [
            'modelName'         => $modelName,
            'modelTableName'    => $modelTableName,
            'validation'        => $validation,
            'rules'             => $rules,
        ];

        // Генерация исходного model\source файла
        $content    = File::generateContent( self::TPL_MODEL_SOURCE, $params );
        $path       = self::DIR_MODEL_SOURCE . $modelName . PHP;
        $path       = self::slashReplace($path);

        File::generateFile( $path, $content );

        // Генерация model
        $path       = self::DIR_MODEL . $modelName . PHP;
        $path       = self::slashReplace($path);
        $content    = File::generateContent( self::TPL_MODEL, $params );
        return ( File::generateFile( $path, $content ) ) ? $path : null;
    }


    /**
     *      Генерация `Migration` по шаблону `app/_/templates/generator/migration`
     *
     *          php _ create/migration name
     *
     * @param string $migrationName
     * @param string $tableName
     * @param string $tableComment
     * @return bool
     */
    public function generateMigration( $migrationName, $tableName = '', $tableComment = '' )
    {
        $migrationName  = self::setupSnakeCase($migrationName);
        $tableName      = self::setupSnakeCase($tableName);

        $params     = [
            'migrationName'     => $migrationName,
            'migrationClass'    => 'm' . date("ymd_His") . '_' . $migrationName,
            'tableName'         => $tableName,
            'tableComment'      => $tableComment,
        ];

        $path       = self::slashReplace( self::DIR_MIGRATION . $params['migrationClass'] . PHP );
        $path       = self::slashReplace($path);

        $content    = File::generateContent( self::TPL_MIGRATION, $params );


        return ( File::generateFile( $path, $content ) ) ? $path : null;
    }
}