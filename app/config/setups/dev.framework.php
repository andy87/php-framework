<?php

$setup = [

    // Реквизиты доступа к Базе Данных
    'db'        => [
        'dsn'           => "mysql:host=____;dbname=____;",
        'username'      => "____",
        'password'      => "____",
        'charset'       => "____",
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