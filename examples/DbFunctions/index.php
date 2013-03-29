<?php
// include('config.php');

define('app_dir', __dir__);
include(dirname(dirname(__dir__)) . '/framework/Zinc.php');

Zinc::loadLib('app');
Zinc::loadLib('db');

$map = SqlFetchSimpleMap('select * from test', 'one', 'two', array());
echo_r($map);

$rows = SqlFetchRows('select * from test', array());
echo_r($rows);
