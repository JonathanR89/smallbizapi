<?php

namespace App\Console\Commands;

use DB;
use PDF;
use Mail;
use Excel;
use App\Submission;
use App\UserSubmission;
use App\Http\Traits\Airtable;
use \DomDocument;

use Illuminate\Console\Command;

class SendEmailReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Report To Users';

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
