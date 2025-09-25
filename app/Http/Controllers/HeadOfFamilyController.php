<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\HeadOfFamilyStoreRequest;
use App\Http\Requests\HeadOfFamilyUpdateRequest;
use App\Http\Resources\HeadOfFamilyResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use Illuminate\Http\Request;

class HeadOfFamilyController extends Controller
{

    private HeadOfFamilyRepositoryInterface $headOfFamilyRepository;

    public function __construct(HeadOfFamilyRepositoryInterface $headOfFamilyRepository)
    {
        $this->headOfFamilyRepository = $headOfFamilyRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $headOfFamilies = $this->headOfFamilyRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::JsonResponse(
                true,
                'Head of Families retrieved successfully',
                HeadOfFamilyResource::collection($headOfFamilies),
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
            $headOfFamilies = $this->headOfFamilyRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::JsonResponse(
                true,
                'Head of Families retrieved successfully',
                PaginateResource::make(
                    $headOfFamilies,
                    HeadOfFamilyResource::class
                ),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeadOfFamilyStoreRequest $request)
    {
        //
        $data = $request->validated();

        try {
            $headOfFamily = $this->headOfFamilyRepository->create($data);

            return ResponseHelper::JsonResponse(
                true,
                'Head of Family created successfully',
                new HeadOfFamilyResource($headOfFamily),
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
            $headOfFamily = $this->headOfFamilyRepository->getById($id);

            return ResponseHelper::JsonResponse(
                true,
                'headOfFamily retrieved successfully',
                new HeadOfFamilyResource($headOfFamily),
                200
            );

            if (!$headOfFamily) {
                return ResponseHelper::JsonResponse(false, 'headOfFamily not found', null, 404);
            }
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeadOfFamilyUpdateRequest $request, HeadOfFamily $headOfFamily)
    {
        $data = $request->validated();

        try {

            $headOfFamily = $this->headOfFamilyRepository->update($headOfFamily->id, $data);

            return ResponseHelper::JsonResponse(
                true,
                'Head of Family updated successfully',
                new HeadOfFamilyResource($headOfFamily),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
