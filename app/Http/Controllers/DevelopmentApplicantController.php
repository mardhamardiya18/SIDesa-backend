<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\DevelopmentApplicantRequest;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use App\Models\Development;
use App\Models\DevelopmentApplicant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DevelopmentApplicantController extends Controller implements HasMiddleware
{

    private DevelopmentApplicantRepositoryInterface $developmentApplicantRepository;

    public function __construct(DevelopmentApplicantRepositoryInterface $developmentApplicantRepository)
    {
        $this->developmentApplicantRepository = $developmentApplicantRepository;
    }

    public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['development-applicant-list|development-applicant-edit|development-applicant-delete']), only: ['index', 'getALlPaginated', 'show']),
            new Middleware(PermissionMiddleware::using(['development-applicant-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['development-applicant-edit']), only: ['update']),
            new Middleware(PermissionMiddleware::using(['development-applicant-delete']), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        try {
            $applicants = $this->developmentApplicantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::JsonResponse(
                true,
                'Development Applicants retrieved successfully',
                DevelopmentApplicantResource::collection($applicants),
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
            $applicants = $this->developmentApplicantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::JsonResponse(
                true,
                'Development Applicants retrieved successfully',
                new PaginateResource($applicants, DevelopmentApplicantResource::class),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DevelopmentApplicantRequest $request)
    {
        $data = $request->validated();

        try {
            $applicant = $this->developmentApplicantRepository->create($data);

            return ResponseHelper::JsonResponse(
                true,
                'Development Applicant created successfully',
                new DevelopmentApplicantResource($applicant),
                201
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DevelopmentApplicant $developmentApplicant)
    {
        //
        try {

            return ResponseHelper::JsonResponse(
                true,
                'Development Applicant retrieved successfully',
                new DevelopmentApplicantResource($developmentApplicant->load('development', 'user')),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DevelopmentApplicantRequest $request, DevelopmentApplicant $developmentApplicant)
    {
        $data = $request->validated();

        try {
            $applicant = $this->developmentApplicantRepository->update($developmentApplicant, $data);

            return ResponseHelper::JsonResponse(
                true,
                'Development Applicant updated successfully',
                new DevelopmentApplicantResource($applicant),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DevelopmentApplicant $developmentApplicant)
    {
        //

        try {
            $this->developmentApplicantRepository->delete($developmentApplicant);

            return ResponseHelper::JsonResponse(
                true,
                'Development Applicant deleted successfully',
                null,
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
