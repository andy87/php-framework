<?php

use \_\components\main\View;

/**
 * @return string
 */
function pathTemplateError()
{
    return __DIR__ . '/../templates/error' . TEMPLATE_FORMAT;
}

/**
 * @param string $title
 * @param string $error
 * @param string|bool $message
 * @param string|bool $context
 */
function errorResponse( $title, $error, $message = false, $context = false )
{
    $view = new View([]);

    echo $view->renderFile( pathTemplateError(), [
        'title'     => $title,
        'error'     => $error,
        'message'   => $message,
        'context'   => $context
    ] );

    exit();
}

/**
 *      Обработчик варнингов
 *
 * @param string $level
 * @param string $message
 * @param string $file
 * @param string $line
 * @param string $context
 */
function errorsHandler( $level, $message, $file, $line, $context )
{
    $errorLevels = [
        1 => 'ERROR',
        2 => 'WARNING',
        4 => 'PARSE',
        8 => 'NOTICE',
    ];
    $level = ( isset($errorLevels[ $level ]) ) ?  $errorLevels[ $level ] : $level;

    errorResponse($level, $message, "{$file}:{$line}", $context );
}

/**
 *  Обработчик Fatal + Parse Error
 * @param string $buffer
 */
function fatalErrorsHandler( $buffer )
{
    $error  = null;

    if ( $buffer )
    {
        $errorList = [ 'Fatal error', 'Parse error' ];

        foreach ( $errorList as $item )
        {
            $mark = "<b>{$item}</b>";

            if ( strpos($buffer, $mark) )
            {
                $error = [
                    'level'     => $item,
                    'message'   => str_replace( $mark, '', $buffer )
                ];
            }
        }

        if ( $error ) errorResponse($error['level'], $error['message'] );
    }
}

set_error_handler('errorsHandler', ERROR_LEVEL );