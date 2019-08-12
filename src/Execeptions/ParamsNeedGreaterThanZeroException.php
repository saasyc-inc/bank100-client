<?php

namespace UnifyRedis\Execeptions;

/**
 * Class ParseException
 * @package App\Modules\Exceptions
 */
class ParamsNeedGreaterThanZeroException extends BaseRedisExeception
{
    public $parse_info;

    public function __construct(
        $receive_num
    ) {
        $message = sprintf("传递的参数应该大于0 实际传递的是%s", $receive_num);

        parent::__construct($message);
    }
}

