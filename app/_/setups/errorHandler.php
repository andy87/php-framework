<?php

use \_\components\main\View;

// наш обработчик ошибок
function errorsHandler( $level, $message, $file, $line, $context )
{
    $errorLevels = [
        1 => 'ERROR',
        2 => 'WARNING',
        4 => 'PARSE',
        8 => 'NOTICE',
    ];
    $level = ( isset($errorLevels[ $level ]) ) ?  $errorLevels[ $level ] : $level;

    $view = new View([]);

    $data = [
        'title'     => $level,
        'error'     => $message,
        'message'   => "{$file}:{$line}",
        'context'   => $context
    ];

    $template = __DIR__ . '/../templates/error' . TEMPLATE_FORMAT;

    echo $view->renderFile( $template , $data );
    exit();
}

set_error_handler('errorsHandler', ERROR_LEVEL );