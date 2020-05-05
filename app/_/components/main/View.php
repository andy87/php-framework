<?php

namespace app\_\components\main;

use app\_\App;
use app\_\base\Core;
use app\_\components\Runtime;
use app\_\helpers\Html;

/**
 * Class View
 * @package app\_\components
 */
class View extends Core
{
    // метки позиционирования подключаемых JS файлов
    const POS_HEAD      = 0;
    const POS_BODY      = 1;
    const POS_FOOTER    = 2;

    /** @var string кодировка докуменда */
    public $charset = DEFAULT_CHARSET;

    /** @@var string язык докуменда  */
    public $lang = DEFAULT_LANG;

    /** @var string заголовок приложения */
    public $title = 'My Application';

    /** @var array массив подключаемых CSS файлов */
    public $css = [];

    /** @var array массив подключаемых JS файлов */
    public $js  = [
        'include'   => [],
        'asset'     => [],
    ];

    /** @var array данные для формирования Меты */
    public $meta = [];

    /** @var array стандартные опции подключаемых JS файлов */
    private $defaultJsOptions = [
        'position'  => self::POS_FOOTER,
        'depends'   => null,
    ];

    /** @var string дирректория в которой хранятся обёртки */
    public $layoutDir   = '@views/_layouts/';

    /** @var string имя обёртки исполоьзуемой при выводе контента */
    public $layout      = 'main';

    /**
     *      Регистрируем JS файл для включения в контент
     *
     * @param $path
     * @param array $option
     * @param string $id
     */
    public function registerJsFile( $path, $option = [], $id = '' )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( is_string($option) )
        {
            $id = $option;
            $option = [];
        }

        $option = array_merge( $this->defaultJsOptions, $option );

        if( empty($id) )
        {
            $fileName   = pathinfo($path);
            $id         = $fileName['basename'];
        };

        $this->js['asset'][ $id ] = [ $path, $option ];
    }

    /**
     *      Регистрируем CSS файл для включения в контент
     *
     * @param $path
     */
    public function registerCssFile( $path )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->css[] = $path;
    }

    /**
     *      Добавление мет
     *
     * @param $meta string|array
     */
    public function registerMeta( $meta )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->meta[] = $meta;
    }

    /**
     *      Основной рендер
     *
     * @param string $pathTemplate
     * @param array $params
     * @return string
     */
    public function render( $pathTemplate = '', $params = [] )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( strpos( $pathTemplate, DOG) !== false )
        {
            $pathTemplate = App::getAlias( $pathTemplate );
        }

        if ( strpos($pathTemplate, TEMPLATE_FORMAT) === false )
        {
            $pathTemplate .= TEMPLATE_FORMAT;
        }

        if ( ! file_exists( $pathTemplate ) )
        {
            $error = [
                'error'     => 'Template not found',
                'message'   => $pathTemplate
            ];
            $this->exception( $error );
        }

        return $this->renderFile( $pathTemplate, $params );
    }

    /**
     *      Вывод в head
     */
    public function head()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        echo $this->renderMeta();
        echo $this->renderCss();
        echo $this->renderJs( View::POS_HEAD );

        echo App::$app->head();
    }

    /**
     *      Вывод в тело
     */
    public function body()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        echo $this->renderJs( View::POS_BODY );
        echo App::$app->body();
    }

    /**
     *      Вывод в футер
     */
    public function footer()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        echo $this->renderJs( View::POS_FOOTER );

        echo App::$app->footer();
    }


    /**
     *      Вывод всех <meta>
     */
    private function renderMeta()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        foreach ( $this->meta as $attributes )
        {
            echo Html::meta( $attributes ) . RN;
        }
    }

    /**
     *      Вывод всех CSS
     */
    private function renderCss()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        foreach ( $this->css as $fileCss )
        {
            echo Html::link( $fileCss ) . RN;
        }
    }

    /**
     *      Вывод всех JS
     *
     * @param int $position
     */
    private function renderJs( $position = 0 )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        foreach ( $this->js['asset'] as $id => $dataJS )
        {
            $pos        = $dataJS[1]['position'];
            $fileJS     = $dataJS[0]; // path

            if ( $position !== $pos || in_array($fileJS, $this->js['include']) ) continue;

            $depends    = $dataJS[1]['depends'];

            echo $this->appendJS( $id, $fileJS, $pos, $depends );
        }
    }

    /**
     *      Вывод тега <script>
     *
     * @param string $id
     * @param string $path
     * @param int $position
     * @param string $depends
     */
    private function appendJS( $id = '', $path = '', $position = 0, $depends = '' )
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        if ( !empty($depends) )
        {
            if ( !in_array( $depends, $this->js['include']) )
            {
                $data       = $this->js['asset'][ $depends ];
                $pos        = $position;
                $fileJS     = $data[0]; // path
                $depends    = $data[1]['depends'];
                $this->appendJS( $id, $fileJS, $pos, $depends );
            }
        }

        $this->js['include'][] = $path;
        echo Html::script( $path ) . RN;
    }


    /**
     *          Подключение JS файла из CDN
     */
    public function jQueryInit()
    {
        Runtime::log(static::class, __METHOD__, __LINE__ );

        $this->registerJsFile( SRC_JQUERY_MIN, 'jQuery' );
    }
}