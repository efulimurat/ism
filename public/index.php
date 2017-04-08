<?php

ini_set("display_errors", 1);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App/params.php';
require_once __DIR__ . '/../src/App/Helpers/helper.php';
$app = App\app::init();

$app->run();
?>