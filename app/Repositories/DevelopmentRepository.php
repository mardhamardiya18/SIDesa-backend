<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\DevelopmentRepositoryInterface;
use App\Models\Development;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DevelopmentRepository implements DevelopmentRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        $query = Development::where(function ($query) use ($search) {
            if ($search) {
                $query->search($search);
            }
        });

        $query->latest();

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
            $development = new Development();

            $development->thumbnail         = $data['thumbnail']->store('assets/development', 'public');
            $development->name              = $data['name'];
            $development->description       = $data['description'];
            $development->person_in_charge  = $data['person_in_charge'];
            $development->start_date        = $data['start_date'];
            $development->end_date          = $data['end_date'];
            $development->budget            = $data['budget'];
            $development->status            = $data['status'];

            $development->save();
            DB::commit();

            return $development;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }



    public function update(object $item, array $request)
    {
        DB::beginTransaction();
        try {

            if (isset($request['thumbnail'])) {
                $item->thumbnail && Storage::disk('public')->delete($item->thumbnail);
                $item->thumbnail = $request['thumbnail']->store('assets/development', 'public');
            }

            $item->name              = $request['name'];
            $item->description       = $request['description'];
            $item->person_in_charge  = $request['person_in_charge'];
            $item->start_date        = $request['start_date'];
            $item->end_date          = $request['end_date'];
            $item->budget            = $request['budget'];
            $item->status            = $request['status'];

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
        // Implementation here
        DB::beginTransaction();
        try {
            if ($item->thumbnail) {
                Storage::disk('public')->delete($item->thumbnail);
            }

            $item->delete();
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}