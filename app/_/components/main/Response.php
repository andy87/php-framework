<?php

namespace app\_\components\main;

use app\_\base\Core;
use app\_\components\Runtime;

/**
 * Class Response
 * @package app\_\components
 */
class Response extends Core
{
    /** Возможные форматы ответа */
    const FORMAT_HTML  = 'text/html';
    const FORMAT_JSON  = 'application/json';
    const FORMAT_RAW   = 'text/plain';
    const FORMAT_PDF   = 'application/pdf';
    const FORMAT_PNG   = 'image/png';
    const FORMAT_JPG   = 'image/jpeg';
    const FORMAT_GIF   = 'image/gif';

    /** @var string формат ответа */
    public $format = '';

    /** @var string код ответа */
    public $code = DEFAULT_CODE;


    /** @var string кодировка ответа */
    private $charset = DEFAULT_CHARSET;

    /** @var bool признак типа ответа - файл */
    public $isFile      = false;

    /** @var bool признак типа ответа - тектовой документ */
    public $isDocument  = false;


    /** @var array заголовки ответа */
    private $headers = [];

    /** @var string Возвращаемый при запросе контент */
    private $content = '';



    /**
     *      Функция посылает заголовки из массива
     */
    public function sendHeaders()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        foreach ( $this->headers as $header )
        {
            $this->header( $header );
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

        $this->header( $contentType );
    }

    /**
     *      Задаётся кодировка для ответа
     *
     * @param string $charset
     */
    public function setCharset( $charset )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->charset = $charset;
    }

    /**
     *      Добавление заголовка в массив,
     *      который будет обработан и отправлен
     *      перед выводом результата Controller->action()
     *
     * @param string $header
     * @param bool $replace
     * @param null $code
     */
    public function addHeader( $header, $replace = true, $code = null  )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->headers[] = [ $header, $replace, $code ];
    }

    /**
     *      Моментальная отправка заголовка `no-cache`
     */
    public function noCache()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->addHeader("Pragma: no-cache");
    }

    /**
     *      Моментальная отправка заголовка `Location`
     *
     * @param string $uri
     * @param int $code
     */
    public function redirect( $uri = '/', $code = 301 )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->header("Location: {$uri}",TRUE, $code );
    }

    /**
     *      Моментальная отправка кастомного заголовка
     *
     * @param $string
     * @param bool $replace
     * @param null $code
     */
    public function header( $string, $replace = true, $code = null )
    {
        header( $string,$replace, $code );
    }


    /**
     *      Назначение контента - который будет отправлен как ответ на запрос
     *
     * @param string $content
     * @param bool $append
     *
     * @return string
     */
    public function setContent( $content, $append = false )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->content = ( $append )
            ? $this->content . $content
            : $content;

        return $this->content;
    }

    /**
     *      Возвращяет контент - который будет отправлен как ответ на запрос
     *
     * @return string
     */
    public function getContent()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        return $this->content;
    }
}
