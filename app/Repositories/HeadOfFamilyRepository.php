<?php

namespace App\Repositories;

use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HeadOfFamilyRepository implements HeadOfFamilyRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        // Implementation of the method to get all users

        $query = HeadOfFamily::with('user')->where(function ($query) use ($search) {
            if ($search) {
                $query->search($search);
            }
        });

        $query->latest();

        if ($limit) {
            $query->take($limit);
        }

        if ($execute) {
            return $query->get();
        }
        return $query;
    }

    public function getAllPaginated(?string $search, ?int $rowsPerPage)
    {
        $query = $this->getAll($search, $rowsPerPage, false);

        return $query->paginate($rowsPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $userRepository = new UserRepository();
            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $headOfFamily = new HeadOfFamily();
            $headOfFamily->user_id = $user->id;
            $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head_of_family', 'public');
            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];
            $headOfFamily->save();

            DB::commit();
            return $headOfFamily;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    public function getById(string $id)
    {
        return HeadOfFamily::with(['user', 'familyMembers'])->find($id);
    }

    public function update(object $item, array $data)
    {


        DB::beginTransaction();

        try {

            $userRepository = new UserRepository();

            $userRepository->update($item->user_id, [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => isset($data['password']) ? bcrypt($data['password']) : $item->user->password,
            ]);

            if (isset($data['profile_picture'])) {
                $item->profile_picture = $data['profile_picture']->store('assets/head_of_family', 'public');
            }

            $item->identity_number = $data['identity_number'];
            $item->gender = $data['gender'];
            $item->date_of_birth = $data['date_of_birth'];
            $item->phone_number = $data['phone_number'];
            $item->occupation = $data['occupation'];
            $item->marital_status = $data['marital_status'];
            $item->save();

            DB::commit();
            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(object $item)
    {
        DB::beginTransaction();

        try {

            if ($item->profile_picture) {
                Storage::disk('public')->delete($item->profile_picture);
            }
            $item->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}