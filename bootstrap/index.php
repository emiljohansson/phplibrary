<?php
ini_set('display_errors', 1);
$PATH_TO_LIBRARY = $_SERVER['DOCUMENT_ROOT'].'/se/emiljohansson/lib/';
require_once $PATH_TO_LIBRARY.'util/autoloader.php';
addDefaultRootPath($PATH_TO_LIBRARY);
new Main();