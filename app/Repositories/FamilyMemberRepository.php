<?php

namespace App\Repositories;

use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        // Implementation of the method to get all family members

        $query = FamilyMember::with('headOfFamily', 'user')->where(function ($query) use ($search) {
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

            $familyMember = new FamilyMember();

            $familyMember->user_id = $user->id;
            $familyMember->head_of_family_id = $data['head_of_family_id'];
            $familyMember->relation = $data['relation'];
            $familyMember->profile_picture = $data['profile_picture']->store('assets/family_member', 'public');
            $familyMember->identity_number = $data['identity_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->date_of_birth = $data['date_of_birth'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->occupation = $data['occupation'];
            $familyMember->marital_status = $data['marital_status'];

            $familyMember->save();
            DB::commit();

            return $familyMember;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getById(string $id)
    {
        return FamilyMember::with(['user', 'headOfFamily'])->find($id);
    }

    public function update(object $item, array $data)
    {


        DB::beginTransaction();

        try {
            $userRepository = new UserRepository();
            $userRepository->update($item->user_id, [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'] ?? null,
            ]);

            if (isset($data['profile_picture'])) {
                $item->profile_picture = $data['profile_picture']->store('assets/family_member', 'public');
            }

            $item->relation         = $data['relation'];
            $item->identity_number  = $data['identity_number'];
            $item->gender           = $data['gender'];
            $item->date_of_birth    = $data['date_of_birth'];
            $item->phone_number     = $data['phone_number'];
            $item->occupation       = $data['occupation'];
            $item->marital_status   = $data['marital_status'];
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
            $userRepository = new UserRepository();
            $userRepository->delete($item->user_id);

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