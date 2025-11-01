<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventRepository implements EventRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        ?string $status,
        bool $execute
    ) {
        $query = Event::with('eventParticipants')->where(function ($query) use ($search) {
            if ($search) {
                $query->search($search);
            }
        });

        if ($status === 'joined') {
            $query->whereHas('eventParticipants', function ($q) {
                $q->where('head_of_family_id', auth()->user()->headOfFamily->id);
            });
        }

        $query->latest();

        if ($limit) {
            $query->take($limit);
        }

        if ($execute) {
            return $query->get();
        }
        return $query;
    }

    public function getAllPaginated(
        ?string $search,
        ?int $rowsPerPage,
        ?string $status,
    ) {
        $query = $this->getAll($search, $rowsPerPage, $status, false);

        return $query->paginate($rowsPerPage);
    }

    public function create(array $data)
    {

        DB::beginTransaction();
        try {
            $event = new Event();
            $event->thumbnail = $data['thumbnail']->store('assets/events', 'public');
            $event->name = $data['name'];
            $event->description = $data['description'];
            $event->date = $data['date'];
            $event->time = $data['time'];
            $event->price = $data['price'];
            $event->is_active = $data['is_active'];

            $event->save();
            DB::commit();

            return $event;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create event: ' . $e->getMessage());
        }
    }

    public function getById(string $id)
    {
        $limit = 5;

        return Event::with([
            'eventParticipants' => function ($query) use ($limit) {
                // Tambahkan query limit() ke relasi eventParticipants
                $query->limit($limit);
                $query->with('headOfFamily.user');
            }
        ])->find($id);
    }

    public function update(object $item, array $data)
    {
        DB::beginTransaction();
        try {
            if (isset($data['thumbnail'])) {
                $item->thumbnail && Storage::disk('public')->delete($item->thumbnail);
                $item->thumbnail = $data['thumbnail']->store('assets/events', 'public');
            }
            $item->name = $data['name'];
            $item->description = $data['description'];
            $item->date = $data['date'];
            $item->time = $data['time'];
            $item->price = $data['price'];
            $item->is_active = $data['is_active'];

            $item->save();
            DB::commit();

            return $item;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update event: ' . $e->getMessage());
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
            throw new \Exception('Failed to delete event: ' . $e->getMessage());
        }
    }
}
