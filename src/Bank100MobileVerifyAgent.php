<?php

namespace Bank100Client;


use Bank100Client\Configs\Bank100Config;
use Bank100Client\Exceptions\ServerResponseErrorException;
use Bank100Client\Services\LinYunServerRequest;
use Exception;
use SimpleRequest\Exceptions\FailRequestException;

class Bank100MobileVerifyAgent
{
    /**
     * @param $name
     * @param $mobile
     * @param $idcard
     * @return array
     * @throws FailRequestException
     * @throws ServerResponseErrorException
     */
    public static function recordAgent($name, $mobile, $idcard) : array
    {
        $params = [
            'name'    => $name,
            'mobile'  => $mobile,
            'id_card' => $idcard,
        ];

        $path = Bank100Config::getBank100Path();

        $info = LinYunServerRequest::main_post($path, $params);

        $res = self::parser($info, $params);

        [
            "result"    => $result,
            "operation" => $operation,
        ] = $res;

        return [

            "result"    => $result,
            "operation" => $operation,
        ];
    }

    /**
     * @param $info
     * @param $params
     * @return array
     * @throws ServerResponseErrorException
     */
    public static function parser($info, $params) : array
    {
        [
            'name'    => $name,
            'mobile'  => $mobile,
            'id_card' => $idcard,
        ] = $params;

        try {
            [
                "result" =>
                    [
                        "result"    => $result,
                        "operation" => $operation,
                        "code"      => $code,
//                        'msg'       => $msg,
                    ],
            ] = $info;

        } catch (Exception $exception) {
            throw new ServerResponseErrorException($name, $idcard, $mobile);
        }
        if ($code !== Bank100Config::request_success_code) {
            throw new ServerResponseErrorException($name, $idcard, $mobile);
        }

        return [
            "result"    => $result,
            "operation" => $operation,
        ];
    }

}
