<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 18/4/29
 * Time: 下午6:02
 */

namespace EasyShortUrl;

use EasyShortUrl\Exception\EasyShortUrlException;

class EasyShortUrl
{
    private static $instance;
    
    // !!!一但进行使用, 请勿修改该字符串
    const STR_SHUFFLE_62 = '9uDsa6I2GzjMCRg8PXc4ZHFhtmVniwLWYeKyqO7blpQ5BES3TUdAx0Jrk1fvNo';
    
    private function __construct()
    {
    }
    
    public static function getInstance()
    {
        if (!empty(self::$instance)) {
            return self::$instance;
        } else {
            return self::$instance = new self();
        }
    }
    
    /**
     * 构建短网址
     * @param $code
     * @return string
     */
    private function buildShortUrl($code)
    {
        return env('DOMAIN') . '/' .  $code;
    }

    /**
     * 长网址缩短为短网址
     * long url to short url
     * @param $longUrl
     * @param $accessKey
     * @return string
     * @throws EasyShortUrlException
     */
    public function toShort($longUrl, $accessKey)
    {
        $this->validateAccess($accessKey, $longUrl);
        
        $longUrlHash = md5($longUrl . $accessKey);
        
        $existsCode = DB::getInstance()->single("SELECT code FROM esu_url WHERE long_url_hash = ?", [$longUrlHash]);
        if ($existsCode !== false) {
            return $this->buildShortUrl($existsCode);
        }

        $id = DB::getInstance()->insertReturnId('esu_url', [
            'code' => '',
            'long_url' => $longUrl,
            'long_url_hash' => $longUrlHash,
            'request_num' => 0,
            'ip' => esu_get_ip(),
            'access_key' => $accessKey,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $code = $this->base10To62($id);
    
        DB::getInstance()->update('esu_url', ['code' => $code], ['id' => $id]);

        return $this->buildShortUrl($code);
    }
    
    /**
     * 短网址还原为长网址
     * short url restore long url
     * @param $code
     * @return bool
     */
    public function toLong($code)
    {
        $this->validateAccessByCode($code);
        
        $res = DB::getInstance()->row("SELECT id,long_url,request_num FROM esu_url WHERE code = ?", $code);
        
        DB::getInstance()->update('esu_url', ['request_num' => $res['request_num'] + 1], ['id' => $res['id']]);
        return $res['long_url'];
    }
    
    /**
     * 10 进制数转自定义 62 进制数
     * decimal to custom 62 hex
     * @param $num
     * @return string
     */
    public function base10To62($num)
    {
        $res = '';
        while ($num > 0) {
            $res = substr(self::STR_SHUFFLE_62, $num % 62, 1) . $res;
            $num = floor($num / 62);
        }
        return $res;
    }
    
    /**
     * 校验授权
     * validate access
     * @param $accessKey
     * @param $longUrl
     * @throws EasyShortUrlException
     */
    private function validateAccess($accessKey, $longUrl)
    {
        $parseResult = parse_url($longUrl);
        if (!isset($parseResult['host']) || empty($parseResult['host'])) {
            throw new EasyShortUrlException('error long url');
        }
        $res = DB::getInstance()->row("SELECT * FROM esu_access WHERE access_key = ? AND access_domain = ?", $accessKey, $parseResult['host']);
        if (empty($res)) {
            throw new EasyShortUrlException('not access');
        }
    }
    
    /**
     * 校验跳转授权
     * validate access by code
     */
    private function validateAccessByCode($code)
    {
        $res = DB::getInstance()->row("SELECT id,long_url,access_key FROM esu_url WHERE code = ?", $code);
        if (empty($res)) {
            throw new EasyShortUrlException('not found long url');
        }
        
        $this->validateAccess($res['access_key'], $res['long_url']);
    }
}
