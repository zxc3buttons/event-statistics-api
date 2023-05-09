<?php

namespace App\Controller;

use App\Service\EventService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractController
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @Route("/event", name="event_create", methods={"POST"})
     * @throws Exception
     */
    public function createEvent(Request $request): JsonResponse
    {
        $eventName = $request->get('eventName');
        $isAuthorised = $request->get('isAuthorised');
        $ipAddress = $request->getClientIp();

        if (!isset($eventName) || !isset($isAuthorised)) {
            throw new Exception("Fields shouldn't be empty");
        }

        $this->eventService->save($eventName, $isAuthorised, $ipAddress);

        return new JsonResponse(['message' => 'Event created.'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/event", name="event_get", methods={"GET"})
     */
    public function getEvents(Request $request): JsonResponse
    {
        $creationDate = $request->get('creationDate');
        $eventName = $request->get('eventName');
        $groupBy = $request->get('groupBy');

        if (isset($creationDate) && isset($eventName)) {
            $events = $this->eventService->getAllByDateAndName($creationDate, $eventName, $groupBy);
        } else if (isset($creationDate)) {
            $events = $this->eventService->getAllByDate($creationDate, $groupBy);
        } else if (isset($eventName)) {
            $events = $this->eventService->getAllByName($eventName, $groupBy);
        } else {
            $events = $this->eventService->getAll($groupBy);
        }

        return new JsonResponse($events, Response::HTTP_OK);
    }
}
