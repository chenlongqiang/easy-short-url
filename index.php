<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 18/4/29
 * Time: 上午11:49
 */

$is_dev = true;

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

// 获取配置
list($dbConfig, $options) = conf();

// 获取实例
$instance = EasyShortUrl\EasyShortUrl::getInstance($dbConfig, $options);

$code = trim($_SERVER['REQUEST_URI'], '/');
if ($code == 'web_admin') {
    // TODO 下发web授权码

    // web 页
    require './src/WebAdmin.php';
    exit;
} elseif ($code == 'api_gen') {
    // api(POST方法)

    // TODO 控制请求频率

    // TODO 验证授权码
    /*
    if(!in_array($_POST['auth_key'], $authKeys)) {
        echo json_encode(['code' => '1', 'data' => '', 'msg' => 'api not found']);
        exit;
    }
    */

    if ($_POST['type'] == 'to_short') {
        $shortUrl = $instance->toShort(urldecode($_POST['content']));;
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
