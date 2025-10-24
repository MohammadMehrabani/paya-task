<?php

namespace App\SharedKernel\Repositories;

use App\SharedKernel\Contracts\EloquentBaseRepositoryContract;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository implements EloquentBaseRepositoryContract
{
    protected Application $app;
    protected Model $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    abstract public function model(): string;

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model::create($attributes);
    }

    public function update(int|string $id, array $attributes): Model
    {
        $model = $this->model::find($id);

        return tap($model)->update($attributes);
    }

    public function count(array $where): int
    {
        return $this->model::query()->where($where)->count();
    }
}
