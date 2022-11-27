<?php

namespace ArtARTs36\LaravelRuCurrency\Port\Console\Commands;

use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\CourseFetcher;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FetchCoursesCommand extends Command
{
    private const INPUT_OPTION_DATE_NAME = 'date';
    private const INPUT_OPTION_DATE_FORMAT = 'y-m-d';

    protected $signature = "ru-currency:fetch-courses {--date= : Date by format y-m-d}";

    protected $description = 'Fetch currency courses from CBR';

    public function handle(CourseFetcher $fetcher): int
    {
        try {
            $created = $fetcher->fetchOn($this->getInputDate());

            $this->info(sprintf('Created %d courses', $created));

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error(sprintf('Courses not created: %s', $e->getMessage()));

            return self::FAILURE;
        }
    }

    private function getInputDate(): \DateTimeInterface
    {
        $date = $this->input->getOption(self::INPUT_OPTION_DATE_NAME);

        return Carbon::parse(empty($date) ? date(self::INPUT_OPTION_DATE_FORMAT) : $date);
    }
}
