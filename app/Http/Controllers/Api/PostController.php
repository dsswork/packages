<?php

namespace App\Http\Controllers\Api;

use App\DTO\PostData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Models\Post;
use App\Services\ApiAnswerService;
use App\Services\PostService;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public const PER_PAGE = 10;

    public function __construct(protected PostService $postService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postService->all();
        return ApiAnswerService::successfulAnswerWithData($posts);
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $postData = PostData::fromArray($request->validated());
        $post = $this->postService->create($postData);
        return ApiAnswerService::successfulAnswerWithData($post, Response::HTTP_CREATED);
    }

    public function activate(Post $post)
    {
        $this->authorize('activate', $post);
        return $this->postService->activate($post);
    }
}
