<?php
/**
 * Created by PhpStorm.
 * User: i_kugyon
 * Date: 2017/10/19
 * Time: 18:21
 */

namespace FattyRabbit\SqlLog\Utils;


class NetUtils
{
    public static function isIn($remoteIp, $accept)
    {
        if (strpos($accept, '/') === false) {
            return ($remoteIp === $accept);
        }
        list($acceptIp, $mask) = explode('/', $accept);
        $acceptLong            = ip2long($acceptIp) >> (32 - $mask);
        $remoteLong            = ip2long($remoteIp) >> (32 - $mask);

        return ($acceptLong == $remoteLong);
    }
}