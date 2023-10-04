<?php

namespace App\Http\Controllers\Api;

use App\DTO\PackageData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PackageRequest;
use App\Models\Package;
use App\Services\ApiAnswerService;
use App\Services\AdminPackageService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminPackageController extends Controller
{
    public const PER_PAGE = 10;

    public function __construct(protected AdminPackageService $packageService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $packages = $this->packageService->all();
        return ApiAnswerService::successfulAnswerWithData($packages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageRequest $request): JsonResponse
    {
        $packageData = PackageData::fromArray($request->validated());
        $package = $this->packageService->create($packageData);
        return ApiAnswerService::successfulAnswerWithData($package, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package): JsonResponse
    {
        return ApiAnswerService::successfulAnswerWithData($package->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageRequest $request, Package $package): JsonResponse
    {
        $packageData = PackageData::fromArray($request->validated());
        $package = $this->packageService->update($packageData, $package);
        return ApiAnswerService::successfulAnswerWithData($package);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package): JsonResponse
    {
        return $this->packageService->delete($package);
    }
}
