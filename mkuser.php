<?php

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::updateOrCreate(
    ['username' => 'apitest'],
    [
        'name' => 'API Test',
        'email' => 'apitest@tabacare.local',
        'password' => bcrypt('secret123'),
        'role' => 'health_worker',
        'barangay' => 'Visita',
    ]
);

echo "created id={$user->id} barangay={$user->barangay}\n";
