<?php
/** @var $error Exception */
/** @var $message string */
/** @var $debug integer */

use app\_\App;

$title  = ( isset($title) ) ? $title : 'Error';
$params = App::params();

?>

<style>
    h1 {
        width: 100%;
        margin: 15px 0;
        color: #300;
        font: bold 32px/32px Calibri;
        text-align: left;
    }

    pre {
        width: 100%;
        padding: 15px 25px;
        font-family: courier;
        font-size: 12px;
        color: green;
        background-color: black;
        box-sizing: border-box;
    }

    p {
        margin: 25px 0;
        color: #000;
        font: normal 13px/15px Calibri;
        text-align: left;
    }
</style>

<div id="errorPage">

    <h1><?= $title ?></h1>

    <? if ( isset($error) ) : ?>
        <hr>

        <p><?= $error ?></p>
    <? endif; ?>

    <? if ( isset($message) ) : ?>
        <hr>

        <p>
            <? print_r(trim($message)); ?>
        </p>
    <? endif; ?>

    <? if ( $debug ) : ?>

        <? if ( $debug > 0 ) : ?>
            <hr>
            <pre>
                <? print_r( get_included_files() ); ?>
            </pre>
        <? endif; ?>

        <? if ( $debug > 1 ) : ?>
            <hr>
            <pre>
                <? print_r( $params ); ?>
            </pre>
        <? endif; ?>

        <? if ( $debug > 2 ) : ?>
            <hr>
            <pre>
                <? print_r( debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) ); ?>
            </pre>
        <? endif; ?>

        <? if ( $debug > 3 ) : ?>
            <hr>
            <pre>
                <? print_r( get_included_files() ); ?>
            </pre>
        <? endif; ?>

    <? endif; ?>






</div>

