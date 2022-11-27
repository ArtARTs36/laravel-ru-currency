<?php

namespace ArtARTs36\LaravelRuCurrency\Services;

use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\CbrCourseFinder\Contracts\SearchException;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseCreatingException;
use Carbon\Carbon;
use Psr\Log\LoggerInterface;

class CourseFetcher
{
    public function __construct(
        private Finder $finder,
        private CourseCreator $creator,
        private LoggerInterface $logger,
    ) {
        //
    }

    public function fetchOn(\DateTimeInterface $date): int
    {
        $this->logger->info('Start searching courses');

        try {
            $courses = $this->finder->findOnDate($date);
        } catch (SearchException $e) {
            $this->logger->warning(sprintf('Courses not found: %s', $e->getMessage()));

            throw $e;
        }

        $this->logger->info(sprintf('Found %d courses', $courses->count()));

        try {
            $created = $this->creator->createOnDefaultCurrency($courses);
        } catch (CourseCreatingException $e) {
            throw $e;
        }

        $this->logger->info("Added $created courses");

        return $created;
    }
}
