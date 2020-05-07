<?php /** @var $this View */
/** @var string $class */
/** @var string $method */

use _\components\main\View;

echo $this->render('menu', [
    'class'     => $class,
    'method'    => $method,
]);