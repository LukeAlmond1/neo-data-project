<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\RunDailyNeoAnalysisJob;
use App\Jobs\ImportNeoObjectsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;

class ImportNeoDailyCommand extends Command
{
    protected $signature = 'app:import-neo-daily-command';

    protected $description = 'This command pulls data from the NEO API and stores it in the database.';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle() : int
    {
        $date = Carbon::today();

        Bus::chain([
            new ImportNeoObjectsJob($date),
            new RunDailyNeoAnalysisJob($date)
        ])->dispatch();

        return self::SUCCESS;
    }
}
