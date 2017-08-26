<?php

namespace App\Console\Commands;

use \TANIOS\Airtable\Airtable;
use Illuminate\Console\Command;
use App\Http\Traits\AirtableConsultantsTrait;

class SeedDatabaseFromAirtable extends Command
{
    use AirtableConsultantsTrait;


    protected $signature = 'airtable:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    }
}
