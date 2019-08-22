<?php
/**
 * Created by PhpStorm.
 * User: zhu
 * Date: 6/14/19
 * Time: 10:07 AM
 */

namespace Bank100Client\Services;

use Bank100Client\Configs\Bank100Config;
use SimpleRequest\Exceptions\FailRequestException;
use SimpleRequest\SimpleRequest;

class LinYunServerRequest extends SimpleRequest
{
    /**
     * @param $path
     * @param $params
     * @param array $params
     * @return array
     * @throws FailRequestException
     */
    public static function main_post($path, $params = [])
    {
        $token = Bank100Config::getToken();

        $params = array_merge($params, [
            'token' => $token,
        ]);

        $domain = Bank100Config::getDomain();

        $illumination = Bank100Config::illumination;

        return self::json_post_separate($illumination, $domain, $path, $params);
    }
}