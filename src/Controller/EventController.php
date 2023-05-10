<?php

namespace App\Controller;

use App\Service\EventService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

class EventController extends AbstractController
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @OA\Post(
     *     path="/events",
     *     tags={"Events"},
     *     summary="Create an event",
     *     description="Create an event",
     *     @OA\RequestBody(
     *         description="Event object that needs to be created",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Event created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     * @throws Exception
     */
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

    /**
     * @OA\Get(
     *     path="/events",
     *     tags={"Events"},
     *     summary="Get events",
     *     description="Get a list of events",
     *     @OA\Parameter(
     *         name="creationDate",
     *         in="query",
     *         description="Creation date",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="eventName",
     *         in="query",
     *         description="Event name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="groupBy",
     *         in="query",
     *         description="Group by",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="eventName", type="string"),
     *             @OA\Property(property="creationDate", type="string"),
     *             @OA\Property(property="count", type="integer")
     *         )
     *     )
     * )
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
