<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 20/12/31
 * Time: 下午6:01
 */

namespace EasyShortUrl;

use EasyShortUrl\Exception\EasyShortUrlException;
use Predis\Client;

/**
 * Class Cache
 * @package EasyShortUrl
 * @desc 使用 symfony cache 缓存，当前支持 Filesystem: 本地文件缓存, Redis: 缓存
 * @link https://symfony.com/doc/3.4/cache.html
 */
class Cache
{
    private static $client;
    
    private function __construct()
    {
    }
    
    public static function client()
    {
        if (!is_null(self::$client)) {
            return self::$client;
        }
        
        $cacheClient = env('CACHE_CLIENT');
        if ($cacheClient == 'Filesystem') {
            $client = new \Symfony\Component\Cache\Adapter\FilesystemAdapter(ESU_APP_NAME, env('CACHE_DEFAULT_LIFETIME'));
        } elseif ($cacheClient == 'Redis') {
            $redis = new Client(env('REDIS_DSN'));
            $client = new \Symfony\Component\Cache\Adapter\RedisAdapter($redis, ESU_APP_NAME, env('CACHE_DEFAULT_LIFETIME'));
        } else {
            throw new EasyShortUrlException('Not Supported Cache Client');
        }
        self::$client = $client;
        
        return $client;
    }
    
    public static function key($key, $params = [])
    {
        $mapping = [
            'mapping_code_and_long_url' => 'map_{code}',
        ];
    
        $find = $replace = [];
        foreach ($params as $k => $v) {
            $find[] = '{' . $k . '}';
            $replace[] = $v;
        }
        return str_replace($find, $replace, $mapping[$key]);
    }
}
