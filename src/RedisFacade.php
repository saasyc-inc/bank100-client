<?php
/**
 * Created by PhpStorm.
 * User: zhu
 * Date: 7/19/19
 * Time: 5:30 PM
 */


namespace UnifyRedis;


/**
 * Class RedisFacade
 * @package UnifyRedis
 * @method command
 */
class RedisFacade
{
    public static function __callStatic($name, $arguments)
    {
        $class = Redis::class;

        return $class::$name(
            ...$arguments
        );
    }

}