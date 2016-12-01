<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PayrollEntries;

class getPayrollDatesForYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payroll:generate {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Output a CSV containing all the dates that salaries and expenses are paid throughout one year.';

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
        //
        $payroll = new PayrollEntries(($this->argument('year')));
        $payroll_dates = $payroll->getDatesForYear();
        var_dump($payroll_dates);
    }
}
