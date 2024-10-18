# easy-short-url 短网址 2.x
- 使用方式: 可在 Laravel、Yii、ThinkPHP 等框架 Composer 包引入，也可以独立搭建短网址站点
- 实现原理: id 自增（转自定义62进制）  
- 存储: MySQL
- 缓存: 可在配置项 ESU_CACHE_OPEN、ESU_CACHE_CLIENT、ESU_CACHE_LIFETIME 定制
- 安全: 转短网址、跳转长网址授权

## 导航
- [1.x 版本](doc/1.x_README.md)
- [1.x 升级 2.x 指南](doc/1.x_upgrade_2.x.md)

## 2.x 相比 1.x 新特性
- 安全跳转，授权请求密钥、跳转域。基于安全考虑，跳转长网址域名，必须授权才可跳转
- 缓存策略，可配置。可在配置项 ESU_CACHE_OPEN、ESU_CACHE_CLIENT、ESU_CACHE_LIFETIME 定制

## 使用步骤
1.获取包
```
composer require chenlongqiang/easy-short-url "^2"
```

2.创建数据库
```
mysql -u username -ppassword
create database esu character set utf8 collate utf8_general_ci;
```

3.创建数据表
```
mysql -u username -ppassword esu < doc/2.x_esu.sql
```

4.在项目根目录下，创建配置文件 .env
```
cd 你的项目根目录
cp ./vendor/chenlongqiang/easy-short-url/.env_example ./.env
```

5.vi .env 修改配置项
```
# 短网址服务域名
ESU_DOMAIN=http://s.lukachen.com

# 数据库配置
ESU_DB_HOST=127.0.0.1
ESU_DB_DBNAME=esu
ESU_DB_USERNAME=root
ESU_DB_PASSWORD=root
ESU_DB_PORT=3306
ESU_DB_CHARSET=utf8

# Redis 配置
ESU_REDIS_DSN=tcp://127.0.0.1:6379

# 是否开启缓存，可选项 0: 不开启, 1: 开启 (开启缓存，数据表跳转统计将失效)
ESU_CACHE_OPEN=0

# 缓存方式，可选项 Filesystem: 本地文件缓存, Redis: 缓存 (Redis 缓存，依赖 ESU_REDIS_DSN 配置)
ESU_CACHE_CLIENT=Filesystem

# 默认缓存时间 604800 秒 (1星期)
ESU_CACHE_LIFETIME=604800

# web_admin 页 access_key
ESU_WEB_ADMIN_ACCESS_KEY=esu
```

6.授权请求密钥、跳转域名
```
在数据表 esu_access 添加数据即可
```

## 方法列表
1.生成短网址 toShort
```
$shortUrl = \EasyShortUrl\EasyShortUrl::getInstance()->toShort('http://lukachen.com/archives/328/');
```

2.获取原网址 toLong
```
$longUrl = \EasyShortUrl\EasyShortUrl::getInstance()->toLong($code);
```

完成以上步骤，即可在项目中引入本包，toShort、toLong 完成长短链接转化
如果不需要配置独立的转链网站，后面就不用看了 :)  

## 需要搭建转链网站
需搭建类似 http://s.lukachen.com/web_admin 这样的网站，继续以下步骤（本项目已经提供前端页面，做好域名和服务器配置即可）  

1.服务器配置
```
1) apache or nginx 配置 root 目录至 vendor/chenlongqiang/easy-short-url/
2) 配置 rewrite 重写至 index.php，不清楚的自行 baidu、google 或联系我
```

2.web页
```
地址: http://(你的短网址域名 ESU_DOMAIN 配置项)/web_admin
授权: web_admin 页，使用 ESU_WEB_ADMIN_ACCESS_KEY 配置项作为 access_key
```

3.api
```
地址: http://(你的短网址域名 ESU_DOMAIN 配置项)/api_gen
方法: POST
参数:
    type: to_short 或 to_long
    content: url  
    access_key: api 授权密钥，可在 esu_access 新增
```
  
转链网站搭建完成 :)  

## 我的短网址服务，体验地址
http://s.lukachen.com/web_admin  

- 默认授权码 esu，已添加 lukachen.com 域名为合法跳转域，可用该跳转域名体验
- 如长网址为：http://lukachen.com/friends 可缩短网址为 http://s.lukachen.com/LS

### 我的短网址，提供授权使用
需使用我搭建的短网址服务，请发邮件 365499684@qq.com 申请。跳转域名合理，我将会邮件回复授权码，并添加合法跳转域名  
特别说明：
- `我的短网址服务 s.lukachen.com` 不对微信业务开放，因为微信分享非常容易封禁域名，影响到大家使用
- 使用本库自建服务，`自己决定跳转域名范围和使用场景`，键盘侠请自己睁大眼睛看清楚，懒得争论

### 我的短网址，申请模版
```
因 xxx 业务需要，申请短网址服务，跳转目标域名为 
lukachen.com
google.com
baidu.com
```

## 联系我
- QQ: 365499684 (添加时请备注【短网址】)
- Blog: http://lukachen.com/projects
- 短网址 Demo 站点: http://s.lukachen.com/web_admin
- 有疑问，欢迎 Issues
- 有更棒的 Code 建议，欢迎 Pull Requests
- 对你有帮助，请动动小手 Star Thank You :)
