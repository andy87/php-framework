<?php /** @var $content string */
use _core\components\App;
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