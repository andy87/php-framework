<?php
/** @var $this View */
/** @var $content string */

use app\_\components\View;
use \app\_\App;

?>
<!DOCTYPE html>
<html lang="<?= $this->lang ?>">
    <head>
        <meta charset="<?= $this->charset ?>">
        <meta name="template" content="<?= __FILE__ ?>">
        <title> <?= App::$view->title ?> </title>
        <? $this->head(); ?>
    </head>
    <body>
        <? $this->body(); ?>

        <!-- $content: start -->
        <?= $content ?>
        <!-- $content: end -->

        <? $this->footer(); ?>
    </body>
</html>