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

$name       = isset($params[2]) ? $params[2] : null;

switch ( $item )
{
    case 'controller':
        if ( !isset($params[2]) )
        {
            $resp = "Generate controller error: empty `controller name` \r\n Example: _ create/controller Test";
        }
        if ( !$resp )
        {
            $path = $generator->generateController( $name );
        }
        break;

    case 'view':
        if ( !isset($params[2]) )
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
        if ( !isset($params[2]) )
        {
            $resp = "Generate model error: empty `module` name \r\n Example: _ create/module Test";
        }

        if ( !$resp )
        {
            $path = $generator->generateModule( $name );
        }
        break;

    case 'model':
        if ( !isset($params[2]) )
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