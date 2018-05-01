# easy-short-url 短链接生成

composer require chenlongqiang/easy-short-url

## 配置
```
$dbConfig = [
    'host' => '',
    'dbname' => '',
    'username' => '',
    'password' => '',
];
$options = [
    'domain' => 'http://s.lukachen.com',
];
```

## 生成
```
$shortUrl = \EasyShortUrl\EasyShortUrl::getInstance($dbConfig, $options)->toShort('https://www.baidu.com/s?ie=utf-8&f=3&rsv_bp=1&rsv_idx=1&tn=baidu&wd=%E7%95%AA%E8%8C%84%E7%82%92%E8%9B%8B&oq=%25E7%2595%25AA%25E8%258C%2584%25E7%2582%2592%25E8%259B%258B&rsv_pq=85934537000db9aa&rsv_t=3f59xqFrSv6jrDyrT1OVxtG9CRa0wGzUDKU3UBOsxxQkzFQqY9rZWnBIvQQ&rqlang=cn&rsv_enter=0&prefixsug=%25E7%2595%25AA%25E8%258C%2584%25E7%2582%2592%25E8%259B%258B&rsp=0');
// eg: http://s.lukachen.com/9
```

## 访问短链接跳转回长链接
// 访问: http://s.lukachen.com/9 根据nginx or apache配置重写至index.php

```index.php
require 'vendor/autoload.php';

$code = trim($_SERVER['REQUEST_URI'], '/');
$longUrl = \EasyShortUrl\EasyShortUrl::getInstance($dbConfig, $options)->toLong($code);;
header('Location:' . $longUrl, true, 301)
```

## 作者 Blog
http://lukachen.com