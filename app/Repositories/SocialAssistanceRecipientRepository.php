<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistanceRecipientRepositoryInterface;
use App\Models\SocialAssistanceRecipient;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SocialAssistanceRecipientRepository implements SocialAssistanceRecipientRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        // Implementation of the method to get all social assistance recipients

        $query = SocialAssistanceRecipient::with('socialAssistance', 'headOfFamily.user')->where(function ($query) use ($search) {
            if ($search) {
                $query->search($search);
            }
        });

        $query->latest();

        if (auth()->user()->hasRole('head-of-family')) {
            $headOfFamily = auth()->user()->headOfFamily;
            $query->where('head_of_family_id', $headOfFamily->id);
        }

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
            $socialAssistanceRecipient = new SocialAssistanceRecipient();

            $socialAssistanceRecipient->social_assistance_id = $data['social_assistance_id'];
            $socialAssistanceRecipient->head_of_family_id = $data['head_of_family_id'];
            $socialAssistanceRecipient->amount = $data['amount'];
            $socialAssistanceRecipient->reason = $data['reason'];
            $socialAssistanceRecipient->bank = $data['bank'];
            $socialAssistanceRecipient->bank_account_number = $data['bank_account_number'];
            $socialAssistanceRecipient->proof = $data['proof']->store('assets/social_assistance_recipients', 'public');
            $socialAssistanceRecipient->status = $data['status'];

            $socialAssistanceRecipient->save();
            DB::commit();

            return $socialAssistanceRecipient->load(['socialAssistance', 'headOfFamily.user']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getById(string $id)
    {
        return SocialAssistanceRecipient::with(['socialAssistance', 'headOfFamily.user', 'headOfFamily.familyMembers'])->find($id);
    }

    public function update(object $item, array $data)
    {
        DB::beginTransaction();

        try {
            $item->social_assistance_id = $data['social_assistance_id'];
            $item->head_of_family_id = $data['head_of_family_id'];
            $item->amount = $data['amount'];
            $item->reason = $data['reason'];
            $item->bank = $data['bank'];
            $item->bank_account_number = $data['bank_account_number'];
            // Aman untuk semua kasus: file baru, string kosong, null, dsb.
            if (isset($data['proof']) && $data['proof'] instanceof UploadedFile) {
                if ($item->proof) {
                    Storage::disk('public')->delete($item->proof);
                }

                $item->proof = $data['proof']->store('assets/social_assistance_recipients', 'public');
            }
            $item->status = $data['status'];
            $item->save();
            DB::commit();

            return $item;
        } catch (\Exception $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function delete(object $item)
    {
        DB::beginTransaction();

        try {

            $item->proof && Storage::disk('public')->delete($item->proof);

            $item->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
