<?php

$config = require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/services/AutoLoaderService.php';
require_once __DIR__ . '/app/App.php';

use App\App as App;

$app = App::instance();
$app->run($config);