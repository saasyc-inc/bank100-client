<?php
/**
 * Created by PhpStorm.
 * User: zhu
 * Date: 8/22/19
 * Time: 1:42 PM
 */


namespace Bank100Client\Exceptions;

class ServerResponseErrorException extends BaseBank100ClientException
{
    public function __construct($name = '', $idcard = '', $mobile = '')
    {
        $message = sprintf(
            '请求百融服务发生错误 姓名是:%s 身份证号:%s 手机号是:%s', $name, $idcard, $mobile
        );

        parent::__construct($message);
    }
}