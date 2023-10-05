<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ActivePackageIdRequest;
use App\Services\ApiAnswerService;
use App\Services\PackageService;
use Illuminate\Http\JsonResponse;


class PackageController extends Controller
{
    public const PER_PAGE = 10;

    public function __construct(protected PackageService $packageService)
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

    public function buy(ActivePackageIdRequest $request)
    {
        return $this->packageService->buy($request->id);
    }
}
