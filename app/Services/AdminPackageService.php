<?php

namespace App\Services;

use App\DTO\PackageData;
use App\Http\Controllers\Api\AdminPackageController;
use App\Http\Resources\Package\PackageCollection;
use App\Models\Package;

class AdminPackageService
{
    public function all()
    {
        $packages = Package::paginate(AdminPackageController::PER_PAGE);
        $packageArray = PackageCollection::make($packages)->resolve();
        return $packageArray;
    }

    public function create(PackageData $packageData): array
    {
        $package = Package::create($packageData->toArray());
        return $package->toArray();
    }

    public function update(PackageData $packageData, Package $package): array
    {
        $package->update($packageData->toArray());
        return $package->toArray();
    }

    public function delete(Package $package)
    {
        if($package->users()->activePackages()->exists()) {
            return ApiAnswerService::errorAnswer('This package used by users', 409);
        }
        $package->delete();
        return ApiAnswerService::successfulAnswerWithData($package->toArray());
    }
}
