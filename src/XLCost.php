<?php
/**
 * Created by PhpStorm.
 * User: apeipo
 * Date: 2017/6/30
 * Time: 下午7:46
 */

namespace XLUtil;

class XLCost
{
    /**
     * begin和end时间记录
     * @var array
     */
    public static $TIME_CACHE = [];

    /**
     * 耗时记录
     * @var array
     */
    public static $COSTS = [];

    /**
     * time的次数
     * @var array
     */
    public static $CNT = [];

    /**
     * @param $key
     */
    public static function begin($key) {
        if (isset(static::$TIME_CACHE[$key])) {
            unset(static::$TIME_CACHE[$key]);
        }
        $t = microtime(true);
        static::$TIME_CACHE[$key] = [
            "begin" => $t,
            "end"   => 0
        ];
    }

    /**
     * @param $key
     */
    public static function end($key) {
        if(isset(static::$TIME_CACHE[$key])) {
            static::$TIME_CACHE[$key]["end"] = microtime(true);
            $cost = static::getCostOf($key);
            //重复的key处理
            if (isset(static::$COSTS[$key])) {
                static::$COSTS[$key] += $cost;
                static::$CNT[$key]   += 1;
                static::$COSTS[$key . '_avg'] = static::$COSTS[$key] / static::$CNT[$key];
            } else {
                static::$COSTS[$key] = $cost;
                static::$CNT[$key]   = 1;
            }
        }
    }

    /**
     * @param $key
     * @return int
     */
    public static function getCostOf($key) {
        if( !isset(static::$TIME_CACHE[$key]["begin"])
            || !isset(static::$TIME_CACHE[$key]["end"]) ) {
            return -1;
        }
        $tArr = static::$TIME_CACHE[$key];
        $cost = intval($tArr["end"] * 1000 - $tArr["begin"] * 1000);
        return $cost;
    }

    /**
     * @return array
     */
    public static function getCNT() {
        return self::$CNT;
    }

    /**
     * return all cost as string
     * @return string
     */
    public static function str($format = '[%s : %dms]') {
        $res    = '';
        foreach (static::$COSTS as $key => $cost) {
            $res .= sprintf($format, $key, $cost);
        }
        return $res;
    }

    /**
     * clear and return all as arr
     * @return array
     */
    public static function flush() {
        $res  = static::$COSTS;
        static::$TIME_CACHE = [];
        static::$COSTS      = [];
        static::$CNT = [];
        return $res;
    }

    /**
     * return all cost as arr
     * @return
     */
    public static function all() {
        return static::$COSTS;
    }


    /**
     * destruct
     */
    function __destruct() {
        static::$TIME_CACHE = [];
        static::$COSTS      = [];
        static::$CNT = [];
    }


}
