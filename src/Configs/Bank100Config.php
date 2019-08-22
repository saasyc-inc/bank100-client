<?php
/**
 * Created by PhpStorm.
 * User: zhu
 * Date: 8/22/19
 * Time: 1:23 PM
 */

namespace Bank100Client\Configs;

use Yiche\Config\Models\SapiConfig;

class Bank100Config
{
    const column_operation_mean_not_triple_telecom_operation = 4;

    const column_operation_mean_not_triple_telecom_operation_error_msg = '主贷人手机号不是(移动　联通 电信)三大运营商中的任意一家，是否继续推送?';

    const column_result_mean_mobile_not_same_with_id_card = 2;//不一致

    const column_result_mean_mobile_not_same_with_id_card_error_msg = '姓名 身份证 手机号 三要素校验不一致　会影响资金方放款,是否继续推送?';

    const column_result_mean_mobile_same_with_id_card = 1;//一致

    const column_result_mean_mobile_is_invalid = 0;//查无此号

    const request_success_code = 0;

    const column_result_mean_mobile_is_invalid_error_msg = '空号';

    const illumination = '亿车server端';


    public static function getDomain()
    {
        $key = 'yiche.server.domain';

        return SapiConfig::getConfigValue($key);
    }


    public static function getBank100Path()
    {
        return 'open/mobile_inquire';
    }

    public static function getToken()
    {
        $key = 'yiche.server.access.token';

        return SapiConfig::getConfigValue($key);
    }
}
