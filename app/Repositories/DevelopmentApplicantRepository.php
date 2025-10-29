<?php

namespace App\Repositories;

use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use App\Models\DevelopmentApplicant;
use Exception;
use Illuminate\Support\Facades\DB;

class DevelopmentApplicantRepository implements DevelopmentApplicantRepositoryInterface
{

    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute = true
    ) {
        $query = DevelopmentApplicant::with(['development', 'user'])->where(function ($q) use ($search) {
            if ($search) {
                $q->search($search);
            }
        })->latest();


        if ($limit) {
            $query->limit($limit);
        }

        if ($execute) {
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(
        ?string $search,
        ?int $rowsPerPage,
    ) {
        $query = $this->getAll($search, $rowsPerPage, false);

        return $query->paginate($rowsPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $applicant = new DevelopmentApplicant();

            $applicant->development_id = $data['development_id'];
            $applicant->user_id        = $data['user_id'];
            $applicant->status         = 'pending';

            $applicant->save();
            DB::commit();
            return $applicant;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update(object $item, array $request)
    {
        DB::beginTransaction();
        try {
            $item->status = $request['status'];

            $item->save();
            DB::commit();

            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function delete(object $item)
    {
        DB::beginTransaction();
        try {
            $item->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
