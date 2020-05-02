<?php

namespace app\_\components;

use app\_\base\BaseComponent;

/**
 * Class View
 * @package app\_\components
 */
class View extends BaseComponent
{
    /** @var string  */
    public $title = 'My Application';

    private $css = [];

    private $js  = [];



    public $layout      = 'main';

    public $content     = '';

    public function registerJsFile( $path )
    {
        $this->js[] = $path;
    }

    public function registerCssFile( $path )
    {
        $this->css[] = $path;
    }

}