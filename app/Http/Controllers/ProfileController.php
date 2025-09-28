<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Interfaces\ProfileRepositoryInterface;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private ProfileRepositoryInterface $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function index()
    {
        try {

            $profile = $this->profileRepository->get();

            if (!$profile) {
                return ResponseHelper::JsonResponse(false, 'Profile not found', null, 404);
            }

            return ResponseHelper::JsonResponse(
                true,
                'Profile retrieved successfully',
                new ProfileResource($profile->load('profileImages')),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(ProfileRequest $request)
    {
        $data = $request->validated();

        try {
            $profile = $this->profileRepository->create($data);

            return ResponseHelper::JsonResponse(
                true,
                'Profile created successfully',
                new ProfileResource($profile->load('profileImages')),
                201
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();

        try {
            $profile = $this->profileRepository->update($data);

            return ResponseHelper::JsonResponse(
                true,
                'Profile updated successfully',
                new ProfileResource($profile->load('profileImages')),
                201
            );
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
