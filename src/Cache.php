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
        if ($cacheClient == 'FileSystem') {
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
}
