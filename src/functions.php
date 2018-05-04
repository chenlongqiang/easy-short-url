<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 18/4/30
 * Time: 下午9:58
 */

//不同环境下获取真实的IP
if (!function_exists('get_ip')) {
    function get_ip() {
        //判断服务器是否允许$_SERVER
        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }else{
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        }else{
            //不允许就使用getenv获取
            if(getenv('HTTP_X_FORWARDED_FOR')){
                $realip = getenv( "HTTP_X_FORWARDED_FOR");
            }elseif(getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            }else{
                $realip = getenv('REMOTE_ADDR');
            }
        }
        return $realip;
    }
}

if (!function_exists('env')) {
    function env($key) {
        if (function_exists('putenv')) {
            return getenv($key);
        } else {
            return $_ENV[$key];
        }
    }
}
