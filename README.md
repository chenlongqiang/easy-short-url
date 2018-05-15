# easy-short-url 短链接生成

## 获取包
composer require chenlongqiang/easy-short-url

## 创建数据表
mysqldump -u username -p dbname < esu.sql

## 在项目根目录下，创建配置文件 .env
```
cp ./vendor/chenlongqiang/easy-short-url/.env_example ./.env
```

## .env配置项
```
//DOMAIN请带上协议头 http:// or https://
DOMAIN=http://s.lukachen.com
WEB_SESSION_LIFE=600
ACCESS_KEY=easy123456|short099876|url123567

DB_HOST=127.0.0.1
DB_DBNAME=esu
DB_USERNAME=root
DB_PASSWORD=root

TABLE_URL=esu_url
```

## 注意事项
```
apache or nginx 配置项目根目录至 xxx/vendor/chenlongqiang/easy-short-url/

配置rewrite重写至index.php,不清楚的自行baidu、google或联系我

web页:
    - 地址: http://s.lukachen.com/web_admin
    - 授权: web页自带session_key授权,session_key有效期可在 .env 中配置WEB_SESSION_LIFE,单位秒.

API:
    - 地址: http://s.lukachen.com/api_gen
    - 方法: POST
     参数:
        type: to_short 或 to_long
        content: url
        access_key: 授权key,可联系作者获取.使用本包的开发者可随意在自己的.env中新增ACCESS_KEY
```

## 方法列表

### 1.生成短链
```
$shortUrl = \EasyShortUrl\EasyShortUrl::getInstance($dbConfig, $options)->toShort('https://www.baidu.com/s?ie=utf-8&f=3&rsv_bp=1&rsv_idx=1&tn=baidu&wd=%E7%95%AA%E8%8C%84%E7%82%92%E8%9B%8B&oq=%25E7%2595%25AA%25E8%258C%2584%25E7%2582%2592%25E8%259B%258B&rsv_pq=85934537000db9aa&rsv_t=3f59xqFrSv6jrDyrT1OVxtG9CRa0wGzUDKU3UBOsxxQkzFQqY9rZWnBIvQQ&rqlang=cn&rsv_enter=0&prefixsug=%25E7%2595%25AA%25E8%258C%2584%25E7%2582%2592%25E8%259B%258B&rsp=0');
```

### 2.获取原链接
```
$longUrl = \EasyShortUrl\EasyShortUrl::getInstance($dbConfig, $options)->toLong($code);
```

## 作者
- QQ   365499684
- Blog http://lukachen.com
- 我的短链应用 http://s.lukachen.com/web_admin
- 欢迎与我交流,路过的朋友来一记华丽的star哦:)
