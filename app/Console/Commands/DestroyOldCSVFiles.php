<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DestroyOldCSVFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exports:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove CSV files older than 24hrs from public/exports folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filesInFolder = \File::files(storage_path('exports'));
        // dd($filesInFolder);
        $filesArray = [];

        foreach ($filesInFolder as  $file) {
            $filesArray[] = filemtime($file);
            if (time() - filemtime($file) > 86400) {
                echo "Removing ". $file . PHP_EOL;
                unlink($file);
            }
        }
    }
}
