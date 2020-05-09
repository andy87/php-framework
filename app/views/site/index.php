<?php /** @var $this View */
/** @var string $class */
/** @var string $method */

use _\components\main\View;

$this->registerJsFile( '/js/scripts.js',['depends' => 'main.js'] );
$this->registerJsFile( '/js/main.js',['depends' => 'jQuery'] );
$this->jQueryInit();

echo $this->render('menu', [
    'class'     => $class,
    'method'    => $method,
]);