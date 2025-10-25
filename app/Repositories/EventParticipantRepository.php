<?php

namespace App\Repositories;

use App\Interfaces\EventParticipantRepositoryInterface;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\DB;

class EventParticipantRepository implements EventParticipantRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        $query = EventParticipant::with(['event.eventParticipants', 'headOfFamily.user'])->where(function ($query) use ($search) {
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
            $event = Event::find($data['event_id']);

            $eventParticipant = new EventParticipant();
            $eventParticipant->event_id = $data['event_id'];
            $eventParticipant->head_of_family_id = $data['head_of_family_id'];
            $eventParticipant->quantity = $data['quantity'];
            $eventParticipant->total_price = $event->price * $data['quantity'];
            $eventParticipant->payment_status = "pending";

            $eventParticipant->save();
            DB::commit();

            return $eventParticipant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getById(string $id)
    {
        return EventParticipant::with(['event', 'headOfFamily.user'])->find($id);
    }

    public function update(object $item, array $data)
    {
        DB::beginTransaction();
        try {
            $event = Event::find($data['event_id']);


            $item->event_id = $data['event_id'];
            $item->head_of_family_id = $data['head_of_family_id'];
            $item->quantity = $data['quantity'];
            $item->total_price = $event->price * $data['quantity'];
            $item->payment_status = $data['payment_status'];

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
            $item->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
