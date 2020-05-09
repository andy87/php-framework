<?php

return [

    // Реквизиты доступа к Базе Данных
    'db'        => [
        'dsn'           => "mysql:host=127.0.0.1;port:3306;dbname=test;",
        'username'      => "root",
        'password'      => "",
        'charset'       => "utf-8",
    ],

    // Реквизиты для отправки почты
    'mailer'    => [
        'host'          => "____",
        'username'      => "____",
        'password'      => "____",
        'port'          => "____",
        'encryption'    => "____",
    ],

    // Данные для сервера кеширования
    'memcached' => [
        'ip'            => "____",
        'port'          => "____",
    ],

];