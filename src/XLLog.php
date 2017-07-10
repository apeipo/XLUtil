<?php
/**
 * Created by PhpStorm.
 * User: linxianlong
 * Date: 2017/7/10
 * Time: 下午3:58
 */

namespace XLUtil;


/**
 * Class XLLog
 * @package XLUtil
 */
class XLLog
{
    /**
     * @var array
     */
    public static $kvRecords = [];

    /**
     * @var string
     */
    public static $logger = "";

    /**
     * @var string
     */
    public static $logid = "";

    /**
     * @var string
     */
    public static $logidKey = "";

    /**
     * @return string
     */
    public static function getLogid()
    {
        return static::$logid;
    }

    /**
     * @param string $logid
     */
    public static function setLogid($key, $logid)
    {
        static::$logid    = $logid;
        static::$logidKey = $key;
    }

    /**
     * @return string
     */
    public static function getLogger()
    {
        return static::$logger;
    }

    /**
     * @param string $logger
     */
    public static function setLogger($logger)
    {
        static::$logger = $logger;
    }

    /***
     * @param $k
     * @param $v
     */
    public static function addNoticeKV($k, $v) {
        static::$kvRecords[$k] = $v;
    }


    /**
     * 清空并打印
     * @param string $msg
     */
    public static function flush($msg = '') {
        static::notice($msg, static::$kvRecords);
        static::$kvRecords = [];
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($method, $args)
    {
        $logger = static::getLogger();

        if (!$logger) {
            throw new \Exception('Logger Instance Is Not init');
        }

        //在打印的context中添加logid
        if (static::$logid) {
            $args[1][static::$logidKey]  =  static::$logid;
        }

        return $logger->$method(...$args);
    }

}