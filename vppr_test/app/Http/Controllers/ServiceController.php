<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Providers\ServiceCrudProvider;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    protected ServiceCrudProvider $serviceProvider;

    public function __construct(ServiceCrudProvider $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
    }

    public function index(): JsonResponse
    {
        $services = $this->serviceProvider->getAll();

        return response()->json($services);
    }

    public function show(int $id): JsonResponse
    {
        $service = $this->serviceProvider->findById($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        return response()->json(['service' => $service]);
    }

    public function store(StoreServiceRequest $request): JsonResponse
    {
        $service = $this->serviceProvider->create($request->validated());

        return response()->json(['service' => $service], 201);
    }

    public function update(UpdateServiceRequest $request, int $id): JsonResponse
    {
        $service = $this->serviceProvider->findById($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $service = $this->serviceProvider->update($service, $request->validated());

        return response()->json(['service' => $service]);
    }

    public function destroy(int $id): JsonResponse
    {
        $service = $this->serviceProvider->findById($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $this->serviceProvider->delete($service);

        return response()->json(['message' => 'Service deleted successfully']);
    }
}
