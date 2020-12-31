<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 18/4/29
 * Time: 上午11:49
 */

define('ESU_IS_DEV', true);                 // todo dev
define('ESU_ROOT_PATH', realpath(__DIR__)); // 根目录
define('ESU_APP_NAME', 'esu');              // 项目名

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

/*
$cache = new \Symfony\Component\Cache\Adapter\FilesystemAdapter(ESU_APP_NAME);

// create a new item by trying to get it from the cache
// 创建一个新元素并尝试从缓存中得到它
$numProducts = $cache->getItem('stats.num_products');

// assign a value to the item and save it
// 对元素赋值并存储它
$numProducts->set(4711);
$cache->save($numProducts);

// retrieve the cache item
// 取出缓存元素
$numProducts = $cache->getItem('stats.num_products');
if (!$numProducts->isHit()) {
    p('元素在缓存中不存在');
    // ... item does not exists in the cache
    // ... 元素在缓存中不存在
}
// retrieve the value stored by the item
// 取出元素存储的值
$total = $numProducts->get();

// remove the cache item
// 删除缓存元素
$cache->deleteItem('stats.num_products');
*/