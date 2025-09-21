<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    );

    public function getAllPaginated(
        ?string $search,
        ?int $rowsPerPage,
    );

    public function create(array $data);

    public function getById(string $id);

    public function update(string $id, array $data);
}