<?php

namespace ArtARTs36\LaravelRuCurrency\Ports\Console\Commands;

use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\LaravelRuCurrency\Services\CourseCreator;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FetchCoursesCommand extends Command
{
    protected $signature = 'money:fetch-courses {--date=}';

    public function handle(Finder $finder, CourseCreator $creator)
    {
        $date = empty($this->option('date')) ? date('y-m-d') : $this->option('date');

        $added = $creator->createOnDefaultCurrency($finder->getOnDate(Carbon::parse($date)));

        $this->comment("Added $added courses");
    }
}
