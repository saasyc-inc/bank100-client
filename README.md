### 说明　通过百融 获取手机三要素的包

###  配置
```

　 'yiche.server.access.token';  yiche-server 鉴权的token
   'yiche.server.domain';   yiche-server 的域名

```
####  调用


```
    $info = Bank100MobileVerifyAgent::recordAgent($name, $mobile, $idcard) : array
    
    [
            "result"    => $result,  //0：查无此号；1：一致；2：不一致；空 当operation=4时，result为空 
            "operation" => $operation, //1：电信 2：联通 3：移动 4：其他，如170号段等 
    ]=$info
```
        

        
