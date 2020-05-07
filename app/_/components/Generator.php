<?php

namespace _\components;

use _\base\Core;
use _\helpers\File;


/**
 *      Клас для консольных комманд генерации
 */
class Generator extends Core
{
    const TPL_CONTROLLER    = DIR_TEMPLATES . 'generator/controller.tpl';
    const TPL_MODEL         = DIR_TEMPLATES . 'generator/model.tpl';
    const TPL_MODEL_SOURCE  = DIR_TEMPLATES . 'generator/model-source.tpl';
    const TPL_MODULE        = DIR_TEMPLATES . 'generator/module.tpl';
    const TPL_VIEW          = DIR_TEMPLATES . 'generator/view.tpl';

    const DIR_CONTROLLER    = DIR_APP . '/controllers/';
    const DIR_MODEL         = DIR_APP . '/models/';
    const DIR_MODEL_SOURCE  = DIR_APP . '/models/source/';
    const DIR_MODULE        = DIR_APP . '/modules/';
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
        $path       = self::DIR_CONTROLLER . self::normalizeName($controllerName) . CONTROLLER_SUFFIX . PHP;

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
        $controller = self::kebabCase( $controller );
        $view       = self::kebabCase( $view );

        $path       = self::DIR_VIEW . $controller . SLASH . $view . PHP;

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
        $path       = self::DIR_MODULE . self::normalizeName($moduleName) . PHP;

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
        $modelName      = self::normalizeName($modelName);


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
        File::generateFile( $path, $content );

        // Генерация model
        $path       = self::DIR_MODEL . $modelName . PHP;
        $content    = File::generateContent( self::TPL_MODEL, $params );
        return ( File::generateFile( $path, $content ) ) ? $path : null;
    }
}