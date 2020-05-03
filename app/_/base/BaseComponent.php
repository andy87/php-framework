<?php

namespace app\_\base;

use app\_\App;
use app\_\base\traits\Func;

/**
 * Class BaseComponent
 * @package app\_\components
 */
class BaseComponent
{
    use Func;

    /**
     * BaseComponent constructor.
     * @param array $params
     */
    function __construct( $params = [] )
    {
        $className = $this->getClassName(true);

        if ( !empty( $params[ $className ]) AND is_array( $params[ $className ] ) )
        {
            foreach ( $params[ $className ] as $key => $value )
            {
                if ( isset($this->{$key}) )
                {
                    $this->{$key} = $value;
                }
            }
        }
    }

    function __call( $name, $arguments )
    {
        self::printPre([$name, $arguments]);

        if ( App::$request->runtime )
        {
            self::printPre([$name, $arguments]);
        }
    }

    /**
     *
     */
    public function init()
    {
        // ...
    }

    /**
     * @param bool $strToLower
     * @return string
     */
    public function getClassName( $strToLower = false )
    {
        $className = array_pop(explode('\\', static::class) );

        if ( $strToLower ) $className = strtolower($className);

        return $className;
    }

}