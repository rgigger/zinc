<?php
define('instance_dir', __dir__);
define('app_dir', '[[$appDir]]');
include '[[$zincDir]]/Zinc.php';
Zinc::loadLib('app');
Zinc::loadLib('zone');
$i = new Instance();
