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
        }
    }

    /**
     * @param $key
     * @return int
     */
    public static function getCostOf($key) {
        if (isset(static::$COSTS[$key])) {
            return static::$COSTS[$key];
        }
        if( !isset(static::$TIME_CACHE[$key])
            || !isset(static::$TIME_CACHE[$key]["begin"])
            || !isset(static::$TIME_CACHE[$key]["end"]) ) {
            return -1;
        }
        $tArr = static::$TIME_CACHE[$key];
        $cost = intval($tArr["end"] * 1000 - $tArr["begin"] * 1000);
        static::$COSTS[$key] = $cost;
        return $cost;
    }

    /**
     * return all cost as string
     * @return string
     */
    public static function str($format = '[%s : %dms]') {
        $costs  = empty(static::$COSTS) ? static::all() : static::$COSTS;
        $res    = '';
        foreach ($costs as $key => $cost) {
            $res .= sprintf($format, $key, $cost);
        }
        return $res;
    }

    /**
     * clear and return all as arr
     * @return array
     */
    public static function flush() {
        $res  = empty(static::$COSTS) ? static::all() : static::$COSTS;
        static::$TIME_CACHE = [];
        static::$COSTS      = [];
        return $res;
    }

    /**
     * return all cost as arr
     * @return
     */
    public static function all() {
        if (!empty(static::$COSTS)) {
            return static::$COSTS;
        }
        $costs = [];
        foreach (static::$TIME_CACHE as $key => $item) {
            $costs[$key] = static::getCostOf($key);
        }
        return $costs;
    }

}
