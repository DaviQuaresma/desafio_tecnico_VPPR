<?php

namespace App\Providers;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ServiceCrudProvider
{
    public function getAll(): LengthAwarePaginator
    {
        return Service::paginate(15);
    }

    public function findById(int $id): ?Service
    {
        return Service::find($id);
    }

    public function create(array $data): Service
    {
        return Service::create($data);
    }

    public function update(Service $service, array $data): Service
    {
        $service->update($data);
        return $service;
    }

    public function delete(Service $service): bool
    {
        return $service->delete();
    }
}
