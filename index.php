<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 18/4/29
 * Time: 上午11:49
 */

define('ESU_IS_DEV', true);                 // todo dev
define('ESU_ROOT_PATH', realpath(__DIR__)); // 根目录

if (ESU_IS_DEV) {
    ini_set('display_errors', 'on');
    error_reporting(E_ALL | E_STRICT);
    require './vendor/autoload.php';
    $dotenv = new Dotenv\Dotenv(__DIR__);
} else {
    require '../../../vendor/autoload.php';
    $dotenv = new Dotenv\Dotenv(dirname(dirname(dirname(__DIR__))));
}
$dotenv->load();

(new EasyShortUrl\Router(trim($_SERVER['REQUEST_URI'], '/')))->dispatch();