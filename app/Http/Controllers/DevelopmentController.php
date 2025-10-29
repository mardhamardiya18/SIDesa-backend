<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Development\storeRequest;
use App\Http\Requests\Development\updateRequest;
use App\Http\Resources\DevelopmentResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\DevelopmentRepositoryInterface;
use App\Models\Development;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DevelopmentController extends Controller implements HasMiddleware
{

    private DevelopmentRepositoryInterface $developmentRepository;

    public function __construct(DevelopmentRepositoryInterface $developmentRepository)
    {
        $this->developmentRepository = $developmentRepository;
    }

    public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['development-list|development-edit|development-delete']), only: ['index', 'getALlPaginated', 'show']),
            new Middleware(PermissionMiddleware::using(['development-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['development-edit']), only: ['update']),
            new Middleware(PermissionMiddleware::using(['development-delete']), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $developments = $this->developmentRepository->getAll(
                $request->search,
                $request->status,
                $request->limit,
                true
            );

            return ResponseHelper::JsonResponse(
                true,
                'Developments retrieved successfully',
                DevelopmentResource::collection($developments),
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
            $developments = $this->developmentRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['status'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::JsonResponse(
                true,
                'Developments retrieved successfully',
                new PaginateResource($developments, DevelopmentResource::class),
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
        $request = $request->validated();

        try {
            $development = $this->developmentRepository->create($request);

            return ResponseHelper::JsonResponse(
                true,
                'Development created successfully',
                new DevelopmentResource($development),
                201
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Development $development)
    {
        try {
            $development->load('developmentApplicants.user.familyMembers');
            return ResponseHelper::JsonResponse(
                true,
                'Development retrieved successfully',
                new DevelopmentResource($development),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, Development $development)
    {
        $data = $request->validated();

        try {
            $development = $this->developmentRepository->update($development, $data);

            return ResponseHelper::JsonResponse(
                true,
                'Development updated successfully',
                new DevelopmentResource($development),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Development $development)
    {
        //
        try {
            $this->developmentRepository->delete($development);

            return ResponseHelper::JsonResponse(
                true,
                'Development deleted successfully',
                null,
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
