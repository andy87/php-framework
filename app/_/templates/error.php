<?php
/** @var $error Exception */
/** @var $message string */
/** @var $debug integer */

use _\App;

$title  = ( isset( $title ) ) ? $title : 'Error';
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
        color: #ffba00;
        background-color: black;
        box-sizing: border-box;
        border-top: solid 3px #ffba00;
        border-bottom: solid 10px #ffba00;
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

    <? if ( isset( $error ) ) : ?>
        <hr>

        <p><?= $error ?></p>
    <? endif; ?>

    <? if ( isset( $message ) ) : ?>
        <hr>

        <p>
            <? print_r( $message ); ?>
        </p>
    <? endif; ?>

    <? if ( isset( $context ) ) : ?>
        <hr>

        <h5>Context</h5>
        <pre>
            <? print_r( $context ); ?>
        </pre>
    <? endif; ?>

    <? if ( $debug ) : ?>

        <? if ( $debug > 0 ) : ?>
            <hr>
            <h5>debug_backtrace</h5>
            <pre>
                <? print_r( debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ) ); ?>
            </pre>

        <? endif; ?>

        <? if ( $debug > 1 ) : ?>
            <hr>
            <h5>$params</h5>
            <pre>
                <? print_r( $params ); ?>
            </pre>
        <? endif; ?>

        <? if ( $debug > 2 ) : ?>
            <hr>
            <h5>included_files</h5>
            <pre>
                <? print_r( get_included_files() ); ?>
            </pre>
        <? endif; ?>

    <? endif; ?>

</div>

