<?php
require(__DIR__ . "/../vendor/autoload.php");

use XLUtil\XLLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$handler = (new StreamHandler("./test.log", Logger::DEBUG));
$logger  = new Logger('test', [$handler]);

XLLog::setLogger($logger);
XLLog::setLogid("LOG_ID", time());

XLLog::addNoticeKV("file", __FILE__);
XLLog::addNoticeKV("method", "test");
XLLog::warning("This is in test");
XLLog::flush("RequestDone");
