<?php

use _\components\Console;
use _\components\Generator;
use _\models\Migration;

// Тут я хочу оправдаться тем что не подразумевал данный функционал поэтому вышла такая петушня
$_SERVER['DOCUMENT_ROOT'] = str_replace('app\_', '', __DIR__);
$routes = [];

require_once "setups/init.php";

$paramsPath = Console::slashReplace(DIR_APP . '/config/params.php' );
require_once $paramsPath;

$params['console'] = true;

$console = new Console($_SERVER['argv']);
// =======================

switch ( $console->action )
{
    case Console::ACTION_CREATE:

        $generator  = new Generator();

        switch ( $console->method )
        {
            case Generator::ID_CONTROLLER:
                $console->generateController( $generator );
                break;

            case Generator::ID_MODEL:
                $console->generateModel( $generator );
                break;

            case Generator::ID_MODULE:
                $console->generateModule( $generator );
                break;

            case Generator::ID_MIGRATION:
            case 'migrate':
                $console->generateMigration( $generator );
                break;

            case Generator::ID_VIEW:
                $console->generateView( $generator );
                break;
        }
        break;


    /** @noinspection PhpMissingBreakStatementInspection */
    case Console::ACTION_MIGRATE:
        if ( $console->method == 'pending' )
        {
            $console->migratePending();
            break;
        }

    case Console::ACTION_BD:

        if ( ! $console->method )
        {
            switch ( $console->action )
            {
                case Console::ACTION_MIGRATE:
                    $resp = Migration::upgrade();
                    break;
            }

        } else {

            $model = $console->models[ $console->action ];

            if ( $console->arguments )
            {
                $resp = $model::{$console->method}( $console->arguments );

            } else {

                $resp = $model::{$console->method}();
            }

            $console->response = $resp;
        }
        break;

    default:
        $console->setError( Console::ACTION_NOT_FOUND );
        break;
}

$console->response();