<?php

namespace ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher;

use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\CbrCourseFinder\Contracts\SearchException;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseCreatingException;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseFetcher;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Creator\Creator;
use Psr\Log\LoggerInterface;

class Fetcher implements CourseFetcher
{
    public function __construct(
        private Finder          $finder,
        private Creator         $creator,
        private LoggerInterface $logger,
    ) {
        //
    }

    /**
     * @throws CourseCreatingException
     * @throws SearchException
     */
    public function fetchAt(\DateTimeInterface $date): int
    {
        $this->logger->info('Start searching courses');

        try {
            $courses = $this->finder->findAt($date);
        } catch (SearchException $e) {
            $this->logger->warning(sprintf('Courses not found: %s', $e->getMessage()));

            throw $e;
        }

        if ($courses->courses->isEmpty()) {
            $this->logger->info(sprintf('Courses at %s not found', $date->format('Y-m-d')));

            return 0;
        }

        $this->logger->info(
            sprintf('Found %d courses at actual date: %s', $courses->courses->count(), $courses->actualDate->format('Y-m-d')),
        );

        try {
            $created = $this->creator->create($courses);
        } catch (CourseCreatingException $e) {
            $this->logger->warning(sprintf('Courses not created: %s', $e->getMessage()));

            throw $e;
        }

        $this->logger->info(sprintf('Created %d courses', $created));

        return $created;
    }
}
