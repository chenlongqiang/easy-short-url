<?php
/**
 * Created by PhpStorm.
 * User: LukaChen
 * Date: 20/12/31
 * Time: 下午6:01
 */

namespace EasyShortUrl;

use ParagonIE\EasyDB\Factory;

class DB
{
    private static $instance;
    
    private function __construct()
    {
    }
    
    public static function getInstance()
    {
        if (!is_null(self::$instance)) {
            return self::$instance;
        } else {
            return self::$instance = Factory::create(
                "mysql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DBNAME') . ";port=" . env('DB_PORT') . ";charset=" . env('DB_CHARSET'),
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            );
        }
    }
}