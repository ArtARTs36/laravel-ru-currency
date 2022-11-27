<?php

namespace ArtARTs36\LaravelRuCurrency\Service;

use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\CbrCourseFinder\Contracts\SearchException;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseCreatingException;
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

    /**
     * @throws CourseCreatingException
     * @throws SearchException
     */
    public function fetchOn(\DateTimeInterface $date): int
    {
        $this->logger->info('Start searching courses');

        try {
            $courses = $this->finder->findOnDate($date);
        } catch (SearchException $e) {
            $this->logger->warning(sprintf('Courses not found: %s', $e->getMessage()));

            throw $e;
        }

        if ($courses->isEmpty()) {
            $this->logger->info(sprintf('Courses at %s not found', $date->format('Y-m-d')));

            return 0;
        }

        $this->logger->info(sprintf('Found %d courses', $courses->count()));

        try {
            $created = $this->creator->createOnDefaultCurrency($courses);
        } catch (CourseCreatingException $e) {
            $this->logger->warning(sprintf('Courses not created: %s', $e->getMessage()));

            throw $e;
        }

        $this->logger->info(sprintf('Created %d courses', $created));

        return $created;
    }
}
