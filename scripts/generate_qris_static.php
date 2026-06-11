<?php
// Usage: php scripts/generate_qris_static.php 55000
require __DIR__ . '/../vendor/autoload.php';

use App\Services\QrisService;

// bootstrap minimal Laravel app to access config
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$amount = $argv[1] ?? null;
if (! $amount) {
    echo "Usage: php scripts/generate_qris_static.php <amount>\n";
    exit(1);
}

$static = config('kasir.qris_static_payload');
if (empty($static)) {
    echo "No static payload configured in config/kasir.php (KASIR_QRIS_STATIC_PAYLOAD).\n";
    exit(1);
}

$dynamic = QrisService::makeDynamic($static, $amount);
$filename = __DIR__ . "/../public/images/qris_{$amount}.png";

if (! class_exists('\\Endroid\\QrCode\\Builder\\Builder')) {
    echo "endroid/qr-code not installed. Run: composer require endroid/qr-code\n";
    echo "Generated payload (you can use external tool to render QR):\n" . $dynamic . "\n";
    exit(1);
}

try {
    $qr = \Endroid\QrCode\Builder\Builder::create()
        ->data($dynamic)
        ->size(400)
        ->margin(10)
        ->build();
    $png = $qr->getString();
    file_put_contents($filename, $png);
    echo "Saved static QR to public/images/qris_{$amount}.png\n";
} catch (Throwable $e) {
    echo "Failed to generate QR PNG: " . $e->getMessage() . "\n";
    exit(1);
}
