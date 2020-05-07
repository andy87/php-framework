<?php
/** @var $this View */
/** @var $from string */
/** @var $to string */
/** @var $block string */

use _\components\main\View;

$this->registerCssFile( '/css/linear-gradiend.css' );
$this->registerMeta( "auth='1231231231231'" );
$this->registerJsFile( '/js/scripts.js',['depends' => 'main.js'] );
$this->registerJsFile( '/js/main.js',['depends' => 'jQuery'] );
$this->jQueryInit();

?>

<ul data-template="<?= __FILE__ ?>">
    <li>From: <?= $from ?></li>
    <li>To: <?= $to ?></li>
    <li><?= $block ?></li>
</ul>