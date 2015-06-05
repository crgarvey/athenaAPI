<?php
/**
 * @author  Robbie Vaughn
 * @file:   test.php
 * @date:   3/21/15
 * @time:   9:19 PM
 */

require __DIR__.'/../bootstrap/autoload.php';

use CrewkieApi\Request;

$request        = new Request('http://api.ggro.dev', '1d633d60-d00d-11e4-afef-f07577f7714e', '1d633d74-d00d-11e4-afef-f07577f7714e');
var_dump($request->findGameAccount(null, 'Cookie'));
var_dump($request->encryptGameAccountPassword('test2'));
var_dump($request->timeclockFindAllBy('[GM] Cookie'));
