<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 20/12/29
 * Time: 下午6:02
 */

namespace EasyShortUrl;

class Router
{
    private $uri;
    
    public function __construct($uri)
    {
        $this->uri = $uri;
    }
    
    /**
     * 路由分发
     * router dispatch
     * @throws Exception\EasyShortUrlException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function dispatch()
    {
        if (method_exists($this, $this->uri)) {
            call_user_func([$this, $this->uri]);
        } else {
            $this->redirectLongUrl();
        }
        exit;
    }
    
    /**
     * web 管理页
     * web admin
     */
    public function web_admin()
    {
        require ESU_ROOT_PATH . '/src/WebAdmin.php';
        exit;
    }
    
    /**
     * web api
     */
    public function api_gen()
    {
        if ($_POST['type'] == 'to_short') {
            $longUrl = urldecode($_POST['content']);
            if (
                empty($_POST['content'])
                || (strpos($longUrl, 'http://') !== 0 && strpos($longUrl, 'https://') !== 0)
            ) {
                api_error('error scheme, please start with http:// or https://');
            }
            
            try {
                $shortUrl = (EasyShortUrl::getInstance())->toShort($longUrl, $_POST['access_key']);;
                api_success($shortUrl);
            } catch (\Exception $e) {
                api_error($e->getMessage());
            }
        } elseif ($_POST['type'] == 'to_long') {
            $code = trim(parse_url(urldecode($_POST['content']), PHP_URL_PATH), '/');
            try {
                $longUrl = (EasyShortUrl::getInstance())->toLong($code);;
                api_success($longUrl);
            } catch (\Exception $e) {
                api_error($e->getMessage());
            }
        } else {
            api_error('api not found');
        }
    }
    
    /**
     * 跳转长网址
     * redirect to long url
     * @throws Exception\EasyShortUrlException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function redirectLongUrl()
    {
        if (empty($this->uri)) {
            header("HTTP/1.1 404 Not Found");
            exit;
        }
    
        if (env('CACHE_OPEN') === '1') {
            $cacheKey = Cache::key('mapping_code_and_long_url', ['code' => $this->uri]);
            $cache = Cache::client();
            $mapping = $cache->getItem($cacheKey);
            if (!$mapping->isHit()) {
                // 元素在缓存中不存在，被动缓存
                try {
                    $longUrl = (EasyShortUrl::getInstance())->toLong($this->uri);;
                    $mapping->set($longUrl);
                    $cache->save($mapping);
                } catch (\Exception $e) {
                    header("HTTP/1.1 404 Not Found");
                    exit;
                }
            } else {
                $longUrl = $mapping->get();
            }
        } 
        
        // 未启用缓存或从缓存取出失败
        if (!isset($longUrl) || empty($longUrl)) {
            try {
                $longUrl = (EasyShortUrl::getInstance())->toLong($this->uri);;
            } catch (\Exception $e) {
                header("HTTP/1.1 404 Not Found");
                exit;
            }
        }

        header('Location:' . $longUrl, true, 302);
    }
}
