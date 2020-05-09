<?php

return [

    // Реквизиты доступа к Базе Данных
    'db'        => [
        'dsn'           => "mysql:host=localhost;dbname=test;",
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