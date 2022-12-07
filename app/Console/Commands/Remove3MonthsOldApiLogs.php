<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ApiLogs;

class Remove3MonthsOldApiLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Remove3MonthsOldApiLogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove API Logs which are 3 months old';

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
        ApiLogs::where('created_at','<',\Carbon\Carbon::now()->subMonths(3))->delete();
    }
}
