<?php
/** @var $this View */
/** @var $from string */
/** @var $to string */

use \app\_\components\View;

$this->registerCssFile('linear-gradiend.css');

?>

<ul>
    <li>From: <?= $from ?></li>
    <li>To: <?= $to ?></li>
</ul>