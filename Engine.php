<?php

use Core\CoreEngine;
use Core\TimerEngine;

define('START_ENGINE', microtime(true));
define('_DIR_', __DIR__);

$LazyLoader = require_once _DIR_.'/Core/CoreEngines/LazyLoaderEngine.php';

$Timer = new TimerEngine();
$Timer->Start();

$Core = new CoreEngine();
$Core->BeginRouting();
$Core->GetRequest();
$Core->BeginView();
$Core->GenerateTemplate();

$Timer->End();
$Timer->ShowTime();
