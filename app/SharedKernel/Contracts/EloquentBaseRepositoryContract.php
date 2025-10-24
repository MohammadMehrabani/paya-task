<?php

namespace App\SharedKernel\Contracts;

use Illuminate\Database\Eloquent\Model;

interface EloquentBaseRepositoryContract
{
    public function create(array $attributes): Model;

    public function update(int|string $id, array $attributes): Model;

    public function count(array $where): int;
}
