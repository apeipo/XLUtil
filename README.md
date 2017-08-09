# XLUtil

## XLCost
耗时计算封装，使用：

```php
XLCost::begin("costA");
usleep(100 * 1000); //100ms
XLCost::end("costA");

XLCost::begin("costB");
usleep(200 * 1000); //100ms
XLCost::end("costB");

#数组返回
print_r(XLCost::all());

#str返回
print(XLCost::str() . "\n");

# 循环中的耗时计算, 超过一次的项会计算平均耗时
//test repeat
for($i = 0; $i < 5; $i++) {
	XLCost::begin("costRepeat");
	usleep(50 * 1000);
	
	XLCost::begin("costInRepeat");
	usleep(80 * 1000);
	XLCost::end("costInRepeat");
	XLCost::end("costRepeat");
}
print_r("Test Repeat\n");
print_r(XLCost::flush());
```

## XLLog
针对Monolog的包装类

1. addNoticeKV, 只往日志里加notice的key但是不打印, 请求结束时一起打印。
2. logid, 可以在web请求的入口给日志设置logid，后续打印的日志均带有该logid。

使用：

```php
use XLUtil\XLLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$handler = (new StreamHandler("./test.log", Logger::DEBUG));
$logger  = new Logger('test', [$handler]);

XLLog::setLogger($logger);
#设置全局logid， 这个逻辑可以放在web框架的入口，生成logid的方式请自行修改
XLLog::setLogid("LOG_ID", time());

XLLog::addNoticeKV("file", __FILE__); #增加key，但是不打印
XLLog::addNoticeKV("method", "test");
XLLog::warning("This is in test");
XLLog::flush("RequestFinish");  #打印所有的kv并清空

####output
[2017-07-10 13:22:56] test.WARNING: This is in test {"LOG_ID":1499692976} []
[2017-07-10 13:22:56] test.NOTICE: RequestDone {"file":"testMonologDecorator.php","method":"test","LOG_ID":1499692976} []
```



