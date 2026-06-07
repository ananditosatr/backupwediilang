<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$res = $app->make('db')->select("SHOW COLUMNS FROM orders LIKE 'payment_method'");
print_r($res);
