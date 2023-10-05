<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiAnswerService;
use App\Services\PostService;
use App\Services\PackageService;

class UserController extends Controller
{
    public function posts(PostService $postService)
    {
        $posts = $postService->userPosts();
        return ApiAnswerService::successfulAnswerWithData($posts);
    }

    public function packages(PackageService $packageService)
    {
        return $packageService->current();
    }
}
