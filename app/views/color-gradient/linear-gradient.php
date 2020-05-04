<?php
/** @var $this View */
/** @var $from string */
/** @var $to string */
/** @var $block string */

use \app\_\components\View;

$this->registerCssFile('/css/linear-gradiend.css');
$this->registerMeta("auth='1231231231231'");
$this->jQueryInit();

?>

<ul template="<?= __FILE__ ?>">
    <li>From: <?= $from ?></li>
    <li>To: <?= $to ?></li>
    <li><?= $block ?></li>
</ul>