<?php
/** @var $this View */
/** @var $content string */

use _\App;
use _\components\main\View;

?>
<!DOCTYPE html>
<html lang="<?= $this->lang ?>">

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