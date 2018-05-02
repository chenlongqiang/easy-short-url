<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 18/4/29
 * Time: 下午6:02
 */

namespace EasyShortUrl;

use ParagonIE\EasyDB\Factory;
use Exception;

class EasyShortUrl
{
    
    // !!!一但进行使用,请勿修改该字符串
    const STR_SHUFFLE_62 = '9uDsa6I2GzjMCRg8PXc4ZHFhtmVniwLWYeKyqO7blpQ5BES3TUdAx0Jrk1fvNo';

    // instance
    private static $instance;
    // 短网址域名
    private $sDomain;
    // 数据库
    private $db;
    private $tableUrl = 'esu_url';
    
    public function __construct($dbConfig, $options)
    {
        $this->setOptions($options);
        $this->setDB($dbConfig);
    }
    
    public static function getInstance($dbConfig, $options)
    {
        if (!empty(self::$instance)) {
            return self::$instance;
        } else {
            return self::$instance = new self($dbConfig, $options);
        }
    }

    public function setDB($dbConfig)
    {
        if (!isset($dbConfig['host'])) {
            throw new Exception('未传数据库地址$dbConfig["host"]');
        }
        if (!isset($dbConfig['dbname'])) {
            throw new Exception('未传数据库名$dbConfig["dbname"]');
        }
        if (!isset($dbConfig['username'])) {
            throw new Exception('未传数据库用户名$dbConfig["username"]');
        }
        if (!isset($dbConfig['password'])) {
            throw new Exception('未传数据库密码$dbConfig["password"]');
        }
        $this->db = Factory::create(
            "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
            $dbConfig['username'],
            $dbConfig['password'] 
        );
    }
    
    public function setOptions($options)
    {
        if (!isset($options['domain'])) {
            throw new Exception('未传短网址域名$options["domain"]');
        }
        $this->sDomain = $options['domain'];
        if (isset($options['tableUrl'])) {
            $this->tableUrl = $options['tableUrl'];
        }
    }

    private function buildShortUrl($code)
    {
        return $this->sDomain . '/' .  $code;
    }

    /**
     * @param $longUrl
     * @return string
     * @throws \Exception
     * @throws \TypeError
     * 
     * 逻辑:
     * 1.判断是否生成过短网址
     * 2.写入数据库,并获取自增id
     * 3.将id转为更短的自定义62进制数(目的:使短网址生成更无规律、更短)
     * 4.数据表更新短网址code字段
     * 5.返回短网址
     */
    public function toShort($longUrl)
    {
        $existsCode = $this->db->single("SELECT code FROM {$this->tableUrl} WHERE long_url_hash = ?", [md5($longUrl)]);
        if ($existsCode !== false) {
            return $this->buildShortUrl($existsCode);
        }

        $id = $this->db->insertReturnId($this->tableUrl, [
            'code' => '',
            'long_url' => $longUrl,
            'long_url_hash' => md5($longUrl),
            'ip' => get_ip(),
            'request_num' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $code = $this->base10To62($id);
        
        $this->db->update($this->tableUrl, ['code' => $code], ['id' => $id]);

        return $this->buildShortUrl($code);
    }
    
    public function toLong($code)
    {
        $res = $this->db->row("SELECT id,long_url,request_num FROM {$this->tableUrl} WHERE code = ?", $code);
        if ($res === false) {
            return false;
        }
        $this->db->update($this->tableUrl, ['request_num' => $res['request_num'] + 1], ['id' => $res['id']]);
        return $res['long_url'];
    }
    
    // 10进制数 转 自定义62进制数
    public function base10To62($num)
    {
        $res = '';
        while ($num > 0) {
            $res = substr(self::STR_SHUFFLE_62, $num % 62, 1) . $res;
            $num = floor($num / 62);
        }
        return $res;
    }

}
