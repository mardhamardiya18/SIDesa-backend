<?php

namespace App\Interfaces;

interface ProfileRepositoryInterface
{

    public function create(array $data);

    public function update(array $request);
}
