<?php

namespace ArtARTs36\LaravelRuCurrency\Ports\Console\Commands;

use ArtARTs36\LaravelRuCurrency\Services\CourseFetcher;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FetchCoursesCommand extends Command
{
    protected $signature = "money:fetch-courses {--date= : Date by format y-m-d}";

    protected $description = 'Fetch currency courses from CBR';

    public function handle(CourseFetcher $fetcher): int
    {
        $date = empty($this->option('date')) ? date('y-m-d') : $this->option('date');

        try {
            $created = $fetcher->fetchOn(Carbon::parse($date));

            $this->info(sprintf('Created %d courses', $created));

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error(sprintf('Courses not created: %s', $e->getMessage()));

            return self::FAILURE;
        }
    }
}
