<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\EventParticipantRequest;
use App\Http\Requests\EventParticipantUpdateRequest;
use App\Http\Resources\EventParticipantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\EventParticipantRepositoryInterface;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{

    private EventParticipantRepositoryInterface $eventParticipantRepository;

    public function __construct(EventParticipantRepositoryInterface $eventParticipantRepository)
    {
        $this->eventParticipantRepository = $eventParticipantRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        try {
            $eventParticipants = $this->eventParticipantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::JsonResponse(
                true,
                'Event Participants retrieved successfully',
                EventParticipantResource::collection($eventParticipants),
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
        ]);

        try {
            $eventParticipants = $this->eventParticipantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::JsonResponse(
                true,
                'Event Participants retrieved successfully',
                new PaginateResource($eventParticipants, EventParticipantResource::class),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventParticipantRequest $request)
    {
        //
        $request = $request->validated();

        try {
            $eventParticipant = $this->eventParticipantRepository->create($request);

            return ResponseHelper::JsonResponse(
                true,
                'Event Participant created successfully',
                new EventParticipantResource($eventParticipant),
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
        //
        try {
            $eventParticipant = $this->eventParticipantRepository->getById($id);

            if (!$eventParticipant) {
                return ResponseHelper::JsonResponse(
                    false,
                    'Event Participant not found',
                    null,
                    404
                );
            }

            return ResponseHelper::JsonResponse(
                true,
                'Event Participant retrieved successfully',
                new EventParticipantResource($eventParticipant),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventParticipantUpdateRequest $request, EventParticipant $eventParticipant)
    {
        $data = $request->validated();

        try {
            if (!$eventParticipant) {
                return ResponseHelper::JsonResponse(
                    false,
                    'Event Participant not found',
                    null,
                    404
                );
            }

            $eventParticipant = $this->eventParticipantRepository->update($eventParticipant, $data);

            return ResponseHelper::JsonResponse(
                true,
                'Event Participant updated successfully',
                new EventParticipantResource($eventParticipant),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventParticipant $eventParticipant)
    {
        //
        try {
            $this->eventParticipantRepository->delete($eventParticipant);

            return ResponseHelper::JsonResponse(
                true,
                'Event Participant deleted successfully',
                null,
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}