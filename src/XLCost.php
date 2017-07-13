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
    public static $TIME_CACHE = [];
    public static $COSTS = [];

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
            if (isset(static::$COSTS[$key])) {
                $key = $key . "_" . count(static::$COSTS);
            }
            static::$COSTS[$key] = $cost;
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
        if (!empty(static::$TIME_CACHE)) {
            static::$TIME_CACHE = [];
        }

        if (!empty(static::$COSTS)) {
            static::$COSTS = [];
        }
    }


}
