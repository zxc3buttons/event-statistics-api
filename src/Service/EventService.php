<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\GroupBy;
use App\Repository\EventRepository;
use DateTimeImmutable;

class EventService
{
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function save(string $name, bool $isAuthorised, string $ipAddress): void
    {
        $event = new Event();

        $event->setName($name);
        $event->setIsAuthorised($isAuthorised);
        $event->setIpAddress($ipAddress);
        $event->setCreatedAt(new DateTimeImmutable());

        $this->eventRepository->save($event);
    }

    /**
     * @param string|null $groupBy
     * @return Event[]
     */
    public function getAll(string $groupBy = null): array
    {
        $events = [];

        if (isset($groupBy) && $this->isCorrectGroupByFilter($groupBy)) {
            $events = $this->eventRepository->findAllAndGroupBy($groupBy);
        } else {
            $events = $this->eventRepository->findAll();
        }

        return $events;
    }

    /**
     * @param string $name
     * @param string|null $groupBy
     * @return mixed
     */
    public function getAllByName(string $name, string $groupBy = null): mixed
    {
        $events = [];

        if (isset($groupBy) && $this->isCorrectGroupByFilter($groupBy)) {
            $events = $this->eventRepository->findAllByNameAndGroupBy($name, $groupBy);
        } else {
            $events = $this->eventRepository->findAllByName($name);
        }

        return $events;
    }

    /**
     * @param string $creationDate
     * @param string|null $groupBy
     * @return mixed
     */
    public function getAllByDate(string $creationDate, string $groupBy = null): mixed
    {
        $events = [];

        if (isset($groupBy) && $this->isCorrectGroupByFilter($groupBy)) {
            $events = $this->eventRepository->findAllByDateAndGroupBy($creationDate, $groupBy);
        } else {
            $events = $this->eventRepository->findAllByDate($creationDate);
        }

        return $events;
    }

    /**
     * @param string $creationDate
     * @param string $eventName
     * @param string|null $groupBy
     * @return mixed
     */
    public function getAllByDateAndName(string $creationDate, string $eventName, string $groupBy = null): mixed
    {
        $events = [];

        if (isset($groupBy) && $this->isCorrectGroupByFilter($groupBy)) {
            $events = $this->eventRepository->findAllByNameAndDateAndGroupBy($eventName, $creationDate, $groupBy);
        } else {
            $events = $this->eventRepository->findAllByNameAndDate($eventName, $creationDate);
        }

        return $events;
    }

    /**
     * @param string $groupBy
     * @return bool
     */
    private function isCorrectGroupByFilter(string $groupBy): bool
    {
        return in_array($groupBy, GroupBy::cases());
    }
}
