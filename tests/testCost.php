<?php
require(__DIR__ . "/../vendor/autoload.php");

use XLUtil\XLCost;

/**
 * Created by PhpStorm.
 * User: apeipo
 * Date: 2017/7/10
 * Time: 下午8:41
 */

XLCost::begin("costA");
usleep(100 * 1000); //100ms
XLCost::end("costA");

XLCost::begin("costB");
usleep(200 * 1000); //100ms
XLCost::end("costB");

print_r(XLCost::all());
print_r(XLCost::all());
print(XLCost::str() . "\n");

print_r(XLCost::flush());

print(XLCost::str());
print_r(XLCost::all());