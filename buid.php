<?php
require_once __DIR__ . '../composer/autoload_real.php';
require __DIR__ . "/Autoloader.php";

use app\SQLite\SQLite;

$filename = "mysqlitedb.db";

$startime = time();

if (2 == $argc) {
    $filename = $argv[1];
}

$instance = new SQLite($filename);

if (!$instance->status) {
    echo $instance->error["error"];
    echo $instance->error["info"];
}
$dbsqlite = $instance->sqdb;

$instance->fill(1000);

echo "OK in -> " . (time() - $startime) . "s\n";
