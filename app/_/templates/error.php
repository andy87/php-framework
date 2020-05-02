<?php
/** @var $error Exception */
/** @var $message string */
?>

<style>
    h1 {
        width: 100%;
        margin: 15px 0;
        color: #300;
        font: bold 32px/32px Calibri;
        text-align: left;
    }

    p {
        margin: 25px 0;
        color: #000;
        font: normal 13px/15px Calibri;
        text-align: left;
    }

    pre {
        width: 100%;
        font-family: courier;
        font-size: 12px;
        color: green;
        background-color: black;
    }
</style>

<div id="errorPage">

    <h1>Error</h1>

    <hr>

    <p><?= $message ?></p>

    <hr>

    <pre>
        <? print_r($error); ?>
    </pre>

</div>

