<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Event\storeRequest;
use App\Http\Requests\Event\updateRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class EventController extends Controller implements HasMiddleware
{

    private EventRepositoryInterface $eventRepository;
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['event-list|event-edit|event-delete']), only: ['index', 'getALlPaginated', 'show']),
            new Middleware(PermissionMiddleware::using(['event-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['event-edit']), only: ['update']),
            new Middleware(PermissionMiddleware::using(['event-delete']), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        try {
            $events = $this->eventRepository->getAll(
                $request->search,
                $request->limit,
                $request->status,
                true
            );

            return ResponseHelper::JsonResponse(
                true,
                'Events retrieved successfully',
                EventResource::collection($events),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer',
            'status' => 'nullable|string',
        ]);

        try {
            $events = $this->eventRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page'],
                $request['status'] ?? null,
            );

            return ResponseHelper::JsonResponse(
                true,
                'Events retrieved successfully',
                new PaginateResource($events, EventResource::class),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        try {
            $event = $this->eventRepository->create($request->validated());

            return ResponseHelper::JsonResponse(
                true,
                'Event created successfully',
                new EventResource($event),
                201
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $event = $this->eventRepository->getById($id);

            if (!$event) {
                return ResponseHelper::JsonResponse(false, 'Event not found', null, 404);
            }

            return ResponseHelper::JsonResponse(
                true,
                'Event retrieved successfully',
                new EventResource($event),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, Event $event)
    {
        //
        try {
            $event = $this->eventRepository->update($event, $request->validated());

            return ResponseHelper::JsonResponse(
                true,
                'Event updated successfully',
                new EventResource($event),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
        try {
            $this->eventRepository->delete($event);

            return ResponseHelper::JsonResponse(
                true,
                'Event deleted successfully',
                null,
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
