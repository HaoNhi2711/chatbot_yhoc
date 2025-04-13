<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StartFastApi extends Command
{
    protected $signature = 'fastapi:start';
    protected $description = 'Start FastAPI server';

    public function handle()
    {
        $this->info('Starting FastAPI server...');

        $process = new Process(['python', '-m', 'uvicorn', 'main:app', '--host', '127.0.0.1', '--port', '8000']);
        $process->setWorkingDirectory(base_path('../fastapi_app')); // Đường dẫn tới fastapi_app
        $process->start();

        if ($process->isRunning()) {
            $this->info('FastAPI is running on http://127.0.0.1:8000');
        } else {
            $this->error('Failed to start FastAPI');
        }
    }
}