<?php
/** @var $content string */

use \app\_\App;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> <?= App::$view->title ?> </title>
    </head>
    <body>
        <?= $content ?>
    </body>
</html>