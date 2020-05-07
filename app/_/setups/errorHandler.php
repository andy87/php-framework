<?php

use \_\components\main\View;

// наш обработчик ошибок
function errorsHandler($level, $message, $file, $line, $context) {
    // в зависимости от типа ошибки формируем заголовок сообщения

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

    echo $view->renderFile($template , $data );
    exit();
}

// регистрируем наш обработчик, он будет срабатывать на для всех типов ошибок
set_error_handler('errorsHandler', ERROR_LEVEL );