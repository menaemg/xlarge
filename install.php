<?php

$laravel_dir = 'http://localhost/last-xlarge/xlarge';

require $laravel_dir . '/bootstrap/autoload.php';

$app = require_once $laravel_dir . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo 'Installing...<br>';
$kernel->call('migrate', ['--force' => true]);

echo 'Seeding...<br>';
$kernel->call('db:seed', ['--force' => true]);

// redirect
echo "<script>window.location = '$site_url'</script>";
