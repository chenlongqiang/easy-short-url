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
     */
    public function dispatch()
    {
        if (method_exists($this, $this->uri)) {
            call_user_func([$this, $this->uri]);
        } else {
            $this->redirect_long_url();
        }
        exit;
    }
    
    /**
     * web 管理页
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
        // todo 验证请求授权
        // esu_validate_access();
        
        if ($_POST['type'] == 'to_short') {
            $longUrl = urldecode($_POST['content']);
            if (
                empty($_POST['content'])
                || (strpos($longUrl, 'http://') !== 0 && strpos($longUrl, 'https://') !== 0)
            ) {
                exit(json_encode(['code' => '2', 'data' => '', 'msg' => '请传递正确的网址(带协议头)']));
            }
            $shortUrl = (EasyShortUrl::getInstance())->toShort($longUrl);;
            exit(json_encode(['code' => '0', 'data' => $shortUrl, 'msg' => 'ok']));
        } elseif ($_POST['type'] == 'to_long') {
            $code = trim(parse_url(urldecode($_POST['content']), PHP_URL_PATH), '/');
            $longUrl = (EasyShortUrl::getInstance())->toLong($code);;
            exit(json_encode(['code' => '0', 'data' => $longUrl, 'msg' => 'ok']));
        } else {
            exit(json_encode(['code' => '1', 'data' => '', 'msg' => 'api not found']));
        }
    }
    
    public function redirect_long_url()
    {
        if (empty($this->uri)) {
            header("HTTP/1.1 404 Not Found");
            exit;
        }
    
        // todo 验证跳转授权
        // esu_validate_access();
    
        // todo cache
        // http://www.symfonychina.com/doc/current/components/cache.html
        // https://github.com/symfony/cache
        $cache = false;
        if ($cache) {
            $longUrl = '';
        } else {
            $longUrl = (EasyShortUrl::getInstance())->toLong($this->uri);
        }
        if ($longUrl === false) {
            header("HTTP/1.1 404 Not Found");
            exit;
        } else {
            header('Location:' . $longUrl, true, 302);
            exit;
        }
    }
}
