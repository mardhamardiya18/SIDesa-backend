<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceStoreRequest;
use App\Http\Requests\SocialAssistanceUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceResource;
use App\Interfaces\SocialAssistanceRepositoryInterface;
use App\Models\SocialAssistance;
use App\Repositories\SocialAssistanceRepository;
use Illuminate\Http\Request;

class SocialAssistanceController extends Controller
{

    private SocialAssistanceRepositoryInterface $socialAssistanceRepository;

    public function __construct(SocialAssistanceRepositoryInterface $socialAssistanceRepository)
    {
        $this->socialAssistanceRepository = $socialAssistanceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        try {
            $socialAssistance = $this->socialAssistanceRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::JsonResponse(
                true,
                'Social Assistances retrieved successfully',
                SocialAssistanceResource::collection($socialAssistance),
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
            $socialAssistances = $this->socialAssistanceRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::JsonResponse(
                true,
                'Social Assistances retrieved successfully',
                PaginateResource::make($socialAssistances, SocialAssistanceResource::class),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialAssistanceStoreRequest $request)
    {
        //php 
        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistanceRepository->create($request);

            return ResponseHelper::JsonResponse(
                true,
                'Social Assistance created successfully',
                new SocialAssistanceResource($socialAssistance),
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
            $socialAssistance = $this->socialAssistanceRepository->getById($id);
            if (!$socialAssistance) {
                return ResponseHelper::JsonResponse(false, 'Social Assistance not found', null, 404);
            }

            return ResponseHelper::JsonResponse(
                true,
                'Social Assistance retrieved successfully',
                new SocialAssistanceResource($socialAssistance),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialAssistanceUpdateRequest $request, SocialAssistance $socialAssistance)
    {
        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistanceRepository->update($socialAssistance, $request);

            return ResponseHelper::JsonResponse(
                true,
                'Social Assistance updated successfully',
                new SocialAssistanceResource($socialAssistance),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialAssistance $socialAssistance)
    {
        //
        try {
            $this->socialAssistanceRepository->delete($socialAssistance);

            return ResponseHelper::JsonResponse(
                true,
                'Social Assistance deleted successfully',
                null,
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}