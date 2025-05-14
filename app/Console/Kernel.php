<?php
namespace App\Console;

class Kernel extends ConsoleKernel{
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('stok:cek')->dailyAt('07:00');
    }

    protected $routeMiddleware = [
        // middleware lain...
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];

}