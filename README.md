# hyperf-skeleton

###项目背景

1. 基于zyprosoft/hyperf-common建立的脚手架，用于快速生成一个支持zgw协议的后台开发项目模板


###ZGW协议开发

####
内部库

####一、使用zyprosoft/hyperf-skeleton项目来创建脚手架
1. composer create-project zyprosoft/hyperf-skeleton
2. 完成后执行composer install

####ZGW协议接口开发
三段式接口名：大模块名.控制器.方法
使用AutoController(prefix="大模块名/控制器")进行注解之后，
按照ZGW协议请求便可自动调用到对应的方法
如下示范:ZgwController下使用AutoController(prefix="/common/zgw")进行注解之后便可
请求到sayHello方法
```php
curl -d'{
    "version":"1.0",
    "seqId":"xxxxx",
    "timestamp":1601017327,
    "eventId":1601017327,
    "caller":"test",
    "interface":{
        "name":"common.zgw.sayHello",
        "param":{}
    }
}' http://127.0.0.1:9506
```

####普通协议开发可直接按照想要的路径做AutoController注解即可

####根据需求继承需要鉴权和不需要鉴权的Request
AdminRequest:需要管理员身份的请求
AuthedRequest:需要登陆身份的请求

####zgw协议请求内容防篡改
签名算法:
在hyperf-common.php配置好appId和appSecret
第一步:生成当前时间戳timestamp和随机字符串nonce
第二步:取出协议中的interface.name和param, php eg. ```$name = $reqBody['interface']['name']```;
第三步:将第一步取出的参数按照如下加入到param, php eg. ```$param['interfaceName'] = $name```;
第四步:将第二步的param参数按照首字母升序 
第五步:将第四部参数数组json编码后进行md5编码得到参数字符串paramString,注意这里json编码不要主动编码为Unicode,不转义/字符
第六步:按照下面的格式拼接参数:
appId=$appId&appSecret=$appSecret&nonce=$nonce&timestamp=$timestamp&$paramString;
第七步:用appSecret和第六步字符串采用sha256算法算出签名
第八步:将得到的签名使用参数名signature加入到请求协议的外层即可

重点:如果是接口带文件上传，需要将上述得到的auth和interface字段进行json编码,后端会在获取到请求的时候自动解码

参考请求包
```php
curl -d'{
    "auth":{
       "timestamp":1601017327,
       "nonce":"1601017327",
       "appId":"test",
       "signature":"xxasdfsfdsfffg"
    },
    "version":"1.0",
    "seqId":"xxxxx",
    "timestamp":1601017327,
    "eventId":1601017327,
    "caller":"test",
    "interface":{
        "name":"common.zgw.sayHello",
        "param":{}
    }
}' http://127.0.0.1:9506
```

