<?php
 
use Illuminate\Contracts\Console\Kernel;

 include_once __DIR__.'/../vendor/autoload.php';
$app = include_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$kernel->bootstrap();

$exitCode = $kernel->call('queue:work', [
    '--daemon' => true,
    '--quiet' => true,
]);

// Optionally, you can check the exit code to determine if the queue worker ran successfully
if ($exitCode === 0) {
    echo "Queue worker ran successfully.";
} else {
    echo "Queue worker encountered an error.";
}
