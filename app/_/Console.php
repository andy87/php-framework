<?php

use _\components\Generator;

$_SERVER['DOCUMENT_ROOT'] = str_replace('app\_', '', __DIR__);

require_once "setups/init.php";

$generator = new Generator();

$argv = $_SERVER['argv'];

$actionData = explode( SLASH, $argv[1] );

$action     = $actionData[0];
$item       = $actionData[1];

$params     = $_SERVER['argv'];
$resp       = null;

$name       = ( isset($params[2]) ? $params[2] : null );

switch ( $item )
{
    case 'controller':
    case 'controllers':
        if ( !$name )
        {
            $resp = "Generate controller error: empty `controller name` \r\n Example: _ create/controller Test";
        }
        if ( !$resp )
        {
            $path = $generator->generateController( $name );
        }
        break;

    case 'view':
    case 'views':
        if ( !$name )
        {
            $resp = "Generate view error: empty `controller` name";
        }
        if ( !isset($params[3]) ) $resp .= " and `view` name";
        if ( $resp ) $resp .= "\r\nExample: _ create/view Car show";

        if ( !$resp )
        {
            $path = $generator->generateView( $name, $params[3] );
        }
        break;

    case 'module':
    case 'modules':
        if ( !$name )
        {
            $resp = "Generate model error: empty `module` name \r\n Example: _ create/module Test";
        }

        if ( !$resp )
        {
            $path = $generator->generateModule( $name );
        }
        break;

    case 'model':
    case 'models':
        if ( !$name )
        {
            $resp = "Generate model error: empty `model` name";
        }
        if ( !isset($params[3]) ) $resp .= " and `table` name ";
        if ( $resp ) $resp .= "\r\nExample: _ create/model Car table_car";

        if ( !$resp )
        {
             $path = $generator->generateModel( $name, $params[3] );
        }
        break;

    case 'migrate':
    case 'migration':
        if ( !$name )
        {
            $resp = "Generate migration error: empty `migration` name";
        }

        if ( $resp ) $resp .= "\r\nExample: _ create/migration Product";

        $tableName = ( isset($params[3]) ) ? $params[3] : '';
        $tableComment = ( isset($params[4]) ) ? $params[4] : '';

        if ( !$resp )
        {
             $path = $generator->generateMigration( $name, $tableName, $tableComment );
        }
        break;

    default:
        $resp = "Method not found";
        exit();
}

if ( !$resp )
{
    if ( $path )
    {
        $item = ucfirst($item);
        $resp .= "Generate {$item} `{$name}` - complete: {$path}" . RN;

    } else {

        $resp .= "Generate not exec";
    }
}

echo $resp . RN;

exit();