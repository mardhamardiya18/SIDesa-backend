<?php

namespace App\Interfaces;

interface DevelopmentApplicantRepositoryInterface
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

    public function update(object $item, array $request);

    public function delete(object $item);
}
