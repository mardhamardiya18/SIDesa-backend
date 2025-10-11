<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistanceRepositoryInterface;
use App\Models\SocialAssistance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SocialAssistanceRepository implements SocialAssistanceRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = SocialAssistance::where(function ($query) use ($search) {
            if ($search) {
                $query->search($search);
            }
        });

        if ($limit) {
            $query->take($limit);
        }

        $query->latest();
        if ($execute) {
            return $query->get();
        }
        return $query;
    }

    public function getAllPaginated(?string $search, ?int $rowsPerPage)
    {
        // Implementation of the method to get paginated social assistances

        $query = $this->getAll($search, $rowsPerPage, false);
        return $query->paginate($rowsPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $socialAssistance = new SocialAssistance();
            $socialAssistance->thumbnail = $data['thumbnail']->store('assets/social_assistance', 'public');
            $socialAssistance->name = $data['name'];
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_active = $data['is_active'];
            $socialAssistance->save();

            DB::commit();

            return $socialAssistance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getById(string $id)
    {
        return SocialAssistance::find($id);
    }

    public function update(object $item, array $data)
    {
        DB::beginTransaction();

        try {
            $item->fill([
                'name' => $data['name'],
                'category' => $data['category'],
                'amount' => $data['amount'],
                'provider' => $data['provider'],
                'description' => $data['description'],
                'is_active' => filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN),
            ]);

            if (isset($data['thumbnail'])) {
                $item->thumbnail && Storage::disk('public')->delete($item->thumbnail);
                $item->thumbnail = $data['thumbnail']->store('assets/social_assistance', 'public');
            }
            $item->save();

            DB::commit();

            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(object $item)
    {
        DB::beginTransaction();

        try {
            $item->thumbnail && Storage::disk('public')->delete($item->thumbnail);
            $item->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
