<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Process\Process;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Đường dẫn tới fastapi_app
        $fastApiDir = base_path('fastapi_app'); // C:\Users\DOTRIHAO\chatbot-yhoc\fastapi_app

        if (!is_dir($fastApiDir)) {
            \Log::error('FastAPI directory does not exist: ' . $fastApiDir);
            return;
        }

        $process = new Process(['python', '-m', 'uvicorn', 'main:app', '--host', '127.0.0.1', '--port', '8000']);
        $process->setWorkingDirectory($fastApiDir);
        $process->setTimeout(null);
        $process->start();

        if ($process->isRunning()) {
            \Log::info('FastAPI started successfully on http://127.0.0.1:8000');
        } else {
            \Log::error('Failed to start FastAPI');
        }
    }
}