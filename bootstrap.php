<?php

$appConfig = require './config/app.php';
$authConfig = require './config/auth.php';
$storageConfig = require './config/storage.php';

define('STORAGE_TYPE', $appConfig['storageType']);
define('AUTH_TOKENS_ARR', $authConfig['tokens']);
define('STORAGE_PATH', $storageConfig['path']);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers.php';
