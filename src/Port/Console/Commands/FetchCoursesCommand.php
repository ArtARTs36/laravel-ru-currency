<?php

namespace ArtARTs36\LaravelRuCurrency\Port\Console\Commands;

use ArtARTs36\LaravelRuCurrency\Contracts\CourseFetcher;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\Fetcher;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FetchCoursesCommand extends Command
{
    private const INPUT_OPTION_DATE_NAME = 'date';
    private const INPUT_OPTION_DATE_FORMAT = 'Y-m-d';

    protected $signature = "ru-currency:fetch-courses {--date= : Date by format y-m-d}";

    protected $description = 'Fetch currency courses from CBR';

    public function handle(CourseFetcher $fetcher): int
    {
        try {
            $created = $fetcher->fetchAt($this->getInputDate());

            $this->info(sprintf('Created %d courses', $created));

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error(sprintf('Courses not created: %s', $e->getMessage()));

            return self::FAILURE;
        }
    }

    private function getInputDate(): \DateTimeInterface
    {
        $date = $this->option(self::INPUT_OPTION_DATE_NAME);

        if (! is_string($date) && $date !== '') {
            $date = date(self::INPUT_OPTION_DATE_FORMAT);
        }

        return Carbon::parse($date);
    }
}
