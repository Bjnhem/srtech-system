<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all log files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Xóa tất cả file log trong thư mục storage/logs
        $files = File::glob(storage_path('logs/*.log'));

        foreach ($files as $file) {
            File::delete($file);
        }

        $this->info('All log files have been cleared.');
    }
}
