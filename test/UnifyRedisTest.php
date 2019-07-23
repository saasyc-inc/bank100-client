<?php
/**
 * Created by PhpStorm.
 * User: zhu
 * Date: 7/22/19
 * Time: 3:48 PM
 */

namespace UnifyRedisTest;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\TestCase;
use UnifyRedis\UnifyRedis;

class UnifyRedisTest extends TestCase
{

    /**
     * @test
     */
    public function correct_case()
    {
        Redis::command('zadd',['age',0,1]);

        $key = "test:prefix";

        $i = 0;
        array_map(function ($val) use (&$i, $key) {
            ++$i;

            UnifyRedis::zadd($key, $val, $i);
        }, [
            11,
            211,
            34,
            141,
            35,
            26,
            7,
        ]);

       
    }
}