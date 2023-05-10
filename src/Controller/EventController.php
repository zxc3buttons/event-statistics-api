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

    public function createEvent(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $eventName = $data['name'] ?? null;
        $isAuthorised = $data['isAuthorized'] ?? null;
        $ipAddress = $request->server->get('X-Real-IP') ?? $request->getClientIp();
        $ipv4Address = inet_ntop(substr(inet_pton($ipAddress), 12));

        if (!isset($eventName) || !isset($isAuthorised)) {
            throw new Exception("Fields shouldn't be empty");
        }

        $this->eventService->save($eventName, $isAuthorised, $ipv4Address);

        return new JsonResponse(['message' => 'Event created.'], Response::HTTP_CREATED);
    }

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
