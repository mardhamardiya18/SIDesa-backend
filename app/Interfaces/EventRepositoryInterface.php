<?php

namespace App\Interfaces;

interface EventRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        ?string $status,
        bool $execute
    );

    public function getAllPaginated(
        ?string $search,
        ?int $rowsPerPage,
        ?string $status,
    );

    public function create(array $data);

    public function getById(string $id);

    public function update(object $item, array $data);

    public function delete(object $item);
}
