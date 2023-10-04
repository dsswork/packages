<?php

namespace App\Services;

use App\Http\Controllers\Api\PackageController;
use App\Http\Resources\Package\PackageCollection;
use App\Models\Package;
use Illuminate\Http\JsonResponse;

class PackageService
{
    public function all(): array
    {
        $packages = Package::active()->paginate(PackageController::PER_PAGE);
        $packageArray = PackageCollection::make($packages)->resolve();
        return $packageArray;
    }

    public function buy(int $id): JsonResponse
    {
        $activePackages = auth()->user()->packages()->wherePivot('created_at', '>', now()->subDays(30))->exists();
        if($activePackages) {
            return ApiAnswerService::errorAnswer('You have active package', 404);
        }

        $package = Package::findOrFail($id);
        $package->users()->attach(auth()->id(), ['created_at' => now(), 'publications' => $package->publications]);
        return ApiAnswerService::successfulAnswerWithData($package->toArray());
    }

    public function current()
    {
        $package = auth()->user()->actualPackages()->firstOrFail();
        $package->buy_date =  $package->pivot->created_at->format('d.m.Y');
        $package->publications_lost = $package->pivot->publications;
        unset($package->pivot);
        return ApiAnswerService::successfulAnswerWithData($package->toArray());
    }
}
