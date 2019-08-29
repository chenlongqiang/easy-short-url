# easy-short-url 短网址生成

## 获取包
composer require chenlongqiang/easy-short-url

## 创建数据库
mysql -u username -ppassword
create database esu character set utf8 collate utf8_general_ci;

## 创建数据表
mysql -u username -ppassword esu < esu.sql

## 在项目根目录下，创建配置文件 .env
```
cd 你的项目根目录
cp ./vendor/chenlongqiang/easy-short-url/.env_example ./.env
```

## .env 配置项
```
//生成的短网址
DOMAIN=http://s.lukachen.com
WEB_SESSION_LIFE=600
ACCESS_KEY=easy123456|short099876|url123567

DB_HOST=127.0.0.1
DB_DBNAME=esu
DB_USERNAME=root
DB_PASSWORD=root

TABLE_URL=esu_url
```

## 方法列表

### 设置配置变量
```
$dbConfig = [
    'host' => env('DB_HOST'),
    'dbname' => env('DB_DBNAME'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
];
$options = [
    'domain' => env('DOMAIN'),
    'tableUrl' => env('TABLE_URL'),
];
```

### 1.生成短链
```
$shortUrl = \EasyShortUrl\EasyShortUrl::getInstance($dbConfig, $options)->toShort('http://lukachen.com/archives/328/');
```

### 2.获取原链接
```
$longUrl = \EasyShortUrl\EasyShortUrl::getInstance($dbConfig, $options)->toLong($code);
```

## 注意事项
```
1.完成以上步骤，即可在自己的项目中引入本扩展包，使用 toShort、toLong 完成长短链接转化。

2.需要独立配置短链接站点，本项目也已经提供好前端页面，做好域名配置即可:
    1) apache or nginx 配置项目根目录至 vendor/chenlongqiang/easy-short-url/
    2）配置 rewrite 重写至index.php, 不清楚的自行baidu、google或联系我

3.web页、api也已经提供好，.env DOMAIN 改成自己的域名即可使用
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

## 作者
- 我的QQ 365499684 (添加时备注【短网址】)
- 我的Blog http://lukachen.com
- 我的短网址 http://s.lukachen.com/web_admin
- 觉得对你有所帮助，请点个 star :)
