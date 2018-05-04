<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 18/4/29
 * Time: 上午11:49
 */

$is_dev = false;

if ($is_dev) {
    ini_set('display_errors', 'on');
    error_reporting(E_ALL | E_STRICT);

    require './vendor/autoload.php';
    $dotenv = new Dotenv\Dotenv(__DIR__);
} else {
    require '../../../vendor/autoload.php';
    $dotenv = new Dotenv\Dotenv(dirname(dirname(dirname(__DIR__))));
}

$dotenv->load();

function conf() {
    return [
        // dbConfig
        [
            'host' => env('DB_HOST'),
            'dbname' => env('DB_DBNAME'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
        ],
        // options
        [
            'domain' => env('DOMAIN'),
            'tableUrl' => env('TABLE_URL'),
        ],
    ];
}

function validateAccess()
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

// 获取配置
list($dbConfig, $options) = conf();

// 获取实例
$instance = EasyShortUrl\EasyShortUrl::getInstance($dbConfig, $options);

$code = trim($_SERVER['REQUEST_URI'], '/');
if ($code == 'web_admin') {
    // web 管理页
    
    // 下发web授权
    $sessionKey = esu_session_key(true);
    
    require './src/WebAdmin.php';
    exit;
} elseif ($code == 'api_gen') {
    // api(POST方法)

    // 验证授权码
    validateAccess();

    // TODO 控制请求频率

    if ($_POST['type'] == 'to_short') {
        $longUrl = urldecode($_POST['content']);
        if (empty($_POST['content']) 
            || (strpos($longUrl, 'http://') !== 0 && strpos($longUrl, 'https://') !== 0)
        ) {
            echo json_encode(['code' => '2', 'data' => '', 'msg' => '请传递正确的网址(带协议头)']);
            exit;
        }
        $shortUrl = $instance->toShort($longUrl);;
        echo json_encode(['code' => '0', 'data' => $shortUrl, 'msg' => 'ok']);
    } elseif ($_POST['type'] == 'to_long') {
        $code = trim(parse_url(urldecode($_POST['content']), PHP_URL_PATH), '/');
        $longUrl = $instance->toLong($code);;
        echo json_encode(['code' => '0', 'data' => $longUrl, 'msg' => 'ok']);
    } else {
        echo json_encode(['code' => '1', 'data' => '', 'msg' => 'api not found']);
    }
    exit;
}

// 跳转
$longUrl = $instance->toLong($code);;
if ($longUrl === false) {
    header("HTTP/1.1 404 Not Found");
    exit;
}
header('Location:' . $longUrl, true, 302);
exit;
