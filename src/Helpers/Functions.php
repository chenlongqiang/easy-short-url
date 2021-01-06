<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 18/4/30
 * Time: 下午9:58
 */

if (!function_exists('env')) {
    /**
     * 获取 env 配置
     * @param $key
     * @return array|false|mixed|string
     */
    function env($key) {
        if (function_exists('putenv')) {
            return getenv($key);
        } else {
            return $_ENV[$key];
        }
    }
}

if (!function_exists('p')) {
    /**
     * 开发调试
     * @param $data
     */
    function p($data)
    {
        echo '<pre>';
        print_r($data);
        echo PHP_EOL;
    }
}

if (!function_exists('pe')) {
    /**
     * 开发调试
     * @param $data
     */
    function pe($data)
    {
        p($data);
        exit;
    }
}

/**
 * 不同环境下获取真实的IP
 * @return array|false|mixed|string
 */
function esu_get_ip() {
    // 判断服务器是否允许$_SERVER
    if(isset($_SERVER)){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }else{
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    }else{
        // 不允许就使用getenv获取
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

/**
 * 获取 session key
 * @param bool $refresh
 * @return mixed
 */
function esu_session_key($refresh = false) {
    session_start();
    $sid = session_id();
    
    $lifeTime = env('WEB_SESSION_LIFE'); // 一个 session key 有效期 xx 秒
    
    if (isset($_SESSION[$sid]) && $_SESSION[$sid]['expire'] > time()) {
        if ($refresh) {
            // 刷新有效期
            $_SESSION[$sid]['expire'] = time() + $lifeTime;
            return $_SESSION[$sid]['key'];
        } else {
            return $_SESSION[$sid]['key'];
        }
    } else {
        $_SESSION[$sid] = [
            'key' => esu_session_key_gen($sid),
            'expire' => time() + $lifeTime,
        ];
        return $_SESSION[$sid]['key'];
    }
}

/**
 * session key 生成
 * @param $sid
 * @return string
 */
function esu_session_key_gen($sid) {
    return md5($sid . time() . 'hey!easy-short-url');
}

/**
 * 授权校验
 */
function esu_validate_access()
{
    $accessPass = false;
    if (isset($_POST['access_key']) && in_array($_POST['access_key'], explode('|', env('ACCESS_KEY')))) { // API开发者授权
        $accessPass = true;
    }
    if (isset($_POST['session_key']) && $_POST['session_key'] == esu_session_key()) { // web授权
        $accessPass = true;
    }
    if (!$accessPass) {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }
}

function response($data, $code, $msg = '')
{
    return [
        'code' => $code,
        'data' => $data,
        'msg' => $msg,
    ];
}

function response_success($data = [])
{
    return response($data, '0', 'ok');
}

function response_error($msg = 'error', $data = [])
{
    return response($data, '1', $msg);
}

function api_success($data)
{
    exit(json_encode(response_success($data)));
}

function api_error($msg = 'error', $data = [])
{
    exit(json_encode(response_error($msg, $data)));
}

function api_response($data, $code, $msg = '')
{
    exit(json_encode(response($data, $code, $msg)));
}