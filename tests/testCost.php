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


//test repeat
for($i = 0; $i < 5; $i++) {
	XLCost::begin("costRepeat");
	usleep(50 * 1000);
	
	XLCost::begin("costInRepeat");
	usleep(80 * 1000);
	XLCost::end("costInRepeat");
	XLCost::end("costRepeat");
}
print_r("RepeatCnt\n");
print_r(XLCost::getCNT());
print_r("Test Repeat\n");
print_r(XLCost::flush());

//test error
XLCost::begin("NNNNNNN");
XLCost::end('Error');
XLCost::end('ABc');
print_r(XLCost::all());
