<?php

namespace App\Interfaces;

interface DevelopmentRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?string $status,
        ?int $limit,
        bool $execute
    );

    public function getAllPaginated(
        ?string $search,
        ?string $status,
        ?int $rowsPerPage,
    );

    public function create(array $data);

    public function update(object $item, array $request);

    public function delete(object $item);
}
