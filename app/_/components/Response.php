<?php

namespace app\_\components;

use app\_\base\BaseComponent;

/**
 * Class Response
 * @package app\_\components
 */
class Response extends BaseComponent
{
    const FORMAT_HTML  = 'text/html';
    const FORMAT_JSON  = 'application/json';
    const FORMAT_RAW   = 'text/plain';
    const FORMAT_PDF   = 'application/pdf';
    const FORMAT_PNG   = 'image/png';
    const FORMAT_JPG   = 'image/jpeg';
    const FORMAT_GIF   = 'image/gif';

    /** @var string  */
    public $format = '';

    /** @var string  */
    public $charset = 'utf-8';

    /** @var bool  */
    public $isFile      = false;

    /** @var bool  */
    public $isDocument  = false;


    /** @var array */
    private $headers = [];



    /**
     *
     */
    public function sendHeaders()
    {
        foreach ( $this->headers as $header )
        {
            header( $header );
        }

        $contentType    = "Content-type: {$this->format}";

        switch ( $this->format )
        {
            case Response::FORMAT_HTML:
            case Response::FORMAT_JSON:
            case Response::FORMAT_RAW:
                $this->isDocument = true;
                $contentType   .= "; charset={$this->charset}";
                break;

            default:
                $this->isFile = true;
                break;
        }

        header( $contentType );
    }

    /**
     * @param $header
     */
    public function addHeader( $header )
    {
        $this->headers[] = $header;
    }

    /**
     *
     */
    public function noCache()
    {
        $this->addHeader("Pragma: no-cache");
    }

    /**
     * @param string $uri
     * @param int $code
     */
    public function redirect( $uri = '/', $code = 301 )
    {
        header("Location: {$uri}",TRUE, $code );
    }
}
