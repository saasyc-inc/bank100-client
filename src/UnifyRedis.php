<?php

//use App\Modules\Exceptions\ParamsNeedGreaterThanZeroException;
//use Illuminate\Support\Facades\Redis;

namespace UnifyRedis;
use Illuminate\Support\Facades\Redis as Redis;

class UnifyRedis
{

    /**
     * 想队列里插入一条数据
     * 如果队列为空 插入一个标志
     * @param $key
     * @param $val
     */
    public static function push_get_a_ring(
        $key,
        $val
    ) {
        $len = Redis::command('lpush', [
            $key,
            $val,
        ]);

        if ($len === 1) {
            Redis::command('lpush', [
                $key,
                self::getSignByKey($key),
            ]);
        }
    }

    public static function getSignByKey($key)
    {
        $app_key =
            Settings::get('应用随机数');

        return md5($key . $app_key);
    }


    public static function isDelimiter($key, $val):bool
    {
        return self::getSignByKey($key) === $val;
    }



    public static function command($key, $params)
    {
        return Redis::command($key, $params);
    }

    public static function set($key, $val)
    {
        $val = json_encode($val, JSON_UNESCAPED_UNICODE);

        return UnifyRedis::command('set', [$key, $val]);
    }


    /**
     * 返回数组方便析构 对象校验数据格式比较困难
     * @param $key
     * @return array|string|null
     */
    public static function get($key)
    {
        return json_decode(UnifyRedis::command('get', [$key]), true);
    }

    /**
     * set
     * @param $key
     * @param $val
     * @return mixed
     */
    public static function sadd($key, $val)
    {
        return UnifyRedis::command('sadd', [$key, $val]);
    }

    /**
     * set_members
     * @param $key
     * @return mixed
     */
    public static function smembers($key)
    {
        return UnifyRedis::command('smembers', [$key,]);
    }


    public static function setEx($key, $expire_time, $info)
    {
        return Redis::command('setex', [$key, $expire_time, json_encode($info)]);
    }

    public static function spop($key)
    {
        return Redis::command('spop', [$key,]);
    }

    public static function set_num($key)
    {
        return Redis::command('scard', [$key,]);
    }


    /**
     * 如果有先后顺序的　使用 sort set
     * @param $key
     * @param $num
     * @return array
     */
    public static function spop_ids($key, $num) : array
    {
        if ($num < 1) {
            throw new ParamsNeedGreaterThanZeroException($num);
        }
        $res = [];

        while ($num--) {

            $id = self::spop($key);

            if ($num === null) {
                break;
            }

            $res[] = $id;
        }

        return $res;
    }

    public static function incr($key)
    {
        return Redis::command('incr', [$key,]);
    }

    public static function incrby($key, $num)
    {
        return Redis::command('incrby', [$key, $num]);
    }

    /**
     * set 和中学数学里的　集合是一样的　都是不可重复的　即　同一个set 里不能有两个 1
     * @param string $key
     * @param int $score
     * @param $val
     * @return mixed
     */
    public static function zadd(string $key, int $score, $val)
    {
        return Redis::command(
            'zadd', [$key, $score, $val]
        );
    }

    /**
     * @param string $key
     * @return int
     */
    public static function zcard(string $key) : int
    {
        return Redis::command('zcard', [$key,]);
    }

    public static function zset_remove_latest($key)
    {
        $latest = self::z_set_highest_by_score($key);

        if ($latest !== null) {
            Redis::command('zrem', [$key, $latest]);
        }

        return $latest;
    }

    /**
     * @param $key
     * @param $num
     * @return array
     * @throws ParamsNeedGreaterThanZeroException
     */
    public static function zset_remove_highests($key, $num ) : array
    {
        if ($num < 1) {
            throw new ParamsNeedGreaterThanZeroException($num);
        }

        //如果　一个set 只要
        $set_actual_num = self::zcard($key);

        if ($num > $set_actual_num) {
            $num = $set_actual_num;
        }

        $res = [];

        while ($num--) {

            $id = self::zset_remove_latest($key);

            if ($id !== null) {
                $res[] = $id;
            }
        }

        return $res;
    }


    //这里返回的是　数据从小到大(按照分数排序)
    public static function zrange($key, $min, $max) : array
    {
        return Redis::command('zrange', [$key, $min, $max]);
    }

    //这里返回的是　数据从大到小(按照分数排序) 从 0 开始
    public static function zrevrange($key, $start, $stop) : array
    {
        return Redis::command('zrevrange', [$key, $start, $stop]);
    }

    //这里返回的是　值(分数)在某个区间的　比如　start 是　1  stop 是10 则　返回的是　分数在1-10之间的数据
    public static function zrangebyscore($key, $start, $stop) : array
    {
        return Redis::command('zrangebyscore', [$key, $start, $stop]);
    }


    public static function z_set_highests_by_score($key, $num) : array
    {
        return self::zrevrange($key, 0, $num - 1);
    }

    public static function z_set_highest_by_score($key)
    {
        $info = self::zrevrange($key, 0, 0);

        return $info[ 0 ] ?? null;
    }


}
