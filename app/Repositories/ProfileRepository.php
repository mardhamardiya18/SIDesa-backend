<?php

namespace App\Repositories;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProfileRepository implements \App\Interfaces\ProfileRepositoryInterface
{

    public function get()
    {
        return Profile::with('profileImages')->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $profile = new Profile();
            $profile->thumbnail         = $data['thumbnail']->store('assets/profile', 'public');
            $profile->name              = $data['name'];
            $profile->about             = $data['about'];
            $profile->headman           = $data['headman'];
            $profile->people            = $data['people'];
            $profile->agricultural_area = $data['agricultural_area'];
            $profile->total_area        = $data['total_area'];

            if (array_key_exists('images', $data)) {
                foreach ($data['images'] as $image) {
                    $profile->profileImages()->create([
                        'image' => $image->store('assets/profile/images', 'public')
                    ]);
                }
            }

            $profile->save();
            DB::commit();

            return $profile;
        } catch (\Exception $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function update(array $request)
    {
        DB::beginTransaction();
        try {
            $profile = Profile::with('profileImages')->first();

            if (isset($request['thumbnail'])) {
                $profile->thumbnail && Storage::disk('public')->delete($profile->thumbnail);
                $profile->thumbnail = $request['thumbnail']->store('assets/profile', 'public');
            }


            $profile->name              = $request['name'];
            $profile->about             = $request['about'];
            $profile->headman           = $request['headman'];
            $profile->people            = $request['people'];
            $profile->agricultural_area = $request['agricultural_area'];
            $profile->total_area        = $request['total_area'];

            if (array_key_exists('images', $request)) {
                foreach ($request['images'] as $image) {
                    $profile->profileImages()->create([
                        'image' => $image->store('assets/profile/images', 'public')
                    ]);
                }
            }

            $profile->save();
            DB::commit();

            return $profile;
        } catch (\Exception $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
