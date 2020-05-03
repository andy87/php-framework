<?php
/** @var $this View */
/** @var $content string */

use app\_\components\View;
use \app\_\App;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="<?= $this->charset ?>">
        <title> <?= App::$view->title ?> </title>
        <? $this->head(); ?>
    </head>
    <body>
        <? $this->body(); ?>

        <?= $content ?>

        <? $this->footer(); ?>
    </body>
</html>