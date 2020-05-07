<?php

namespace _\base;

use _\App;
use _\base\prototype\Func;
use _\components\Runtime;

/**
 * Class BaseComponent
 * @package app\_\components
 */
class Core
{
    use Func;

    /**
     *  constructor.
     * @param array $params
     */
    function __construct( $params = [] )
    {
        $className = $this->getClassName( true );

        if ( !empty( $params[ $className ] ) AND is_array( $params[ $className ] ) )
        {
            foreach ( $params[ $className ] as $key => $value )
            {
                if ( isset( $this->{$key} ) )
                {
                    $this->{$key} = $value;
                }
            }
        }
    }

    function __call( $name, $arguments )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $error = [
            'message'   => 'Function not found',
            'error'     => "Function `{$name}`not found",
        ];

        $this->exception( $error );
    }

    /**
     *
     */
    public function init()
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        // ...
    }

    /**
     *      Получение имени скласса
     *
     * @param bool $strToLower
     * @return string
     */
    public function getClassName( $strToLower = false )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        $path       = static::class;
        $arr        = explode( SLASHER, $path );
        $className  = array_pop( $arr );

        if ( $strToLower ) $className = strtolower( $className );

        return $className;
    }

    /**
     *      Обработка исключений
     *
     * @param string|array $error
     * @param int $code
     */
    public static function exception( $error = 'Error', $code = 418 )
    {
        Runtime::log( static::class, __METHOD__, __LINE__ );

        App::$view->layout = false;
        App::setCharset( DEFAULT_CHARSET );

        if ( App::$response->code != 418 )
        {
            App::$response->code = $code;

            $params = ( is_array( $error ) ) ? $error : [ 'error' => $error ];

            $params['debug'] = App::getParams( 'debug' );

            $resp = App::$view->render( TEMPLATE_ERROR, $params );

            App::$response->setContent( $resp );

            App::display();
        }
    }
}