<?php

namespace App\Services;

use App\DTO\PostData;
use App\Http\Controllers\Api\PostController;
use App\Http\Resources\Post\PostCollection;
use App\Models\Post;

class PostService
{

    public function all(int|null $authorId): array
    {
        $posts = Post::active()
            ->when($authorId, function ($query) use ($authorId){
                $query->where('user_id', $authorId);
            })
            ->latest()->paginate(PostController::PER_PAGE);

        $postsArray = PostCollection::make($posts)->resolve();

        return $postsArray;
    }

    public function create(PostData $postData):array
    {
        $post = Post::create($postData->toArray());
        return $post->toArray();
    }

    public function userPosts()
    {
        $posts = Post::where('user_id', auth()->id())->paginate(PostController::PER_PAGE);
        $postsArray = PostCollection::make($posts)->resolve();
        return $postsArray;
    }

    public function activate(Post $post)
    {
        if($post->is_active) {
            return ApiAnswerService::errorAnswer('This post already active', 404);
        }
        $user = auth()->user();
        $hasActivePackage = $user->actualPackages()->exists();
        if($hasActivePackage) {
            $package = $user->actualPackages()->first();
            $hasPublications = $package->pivot->publications > 0;
            if(!$hasPublications) {
                return ApiAnswerService::errorAnswer('You dont have publications', 404);
            } else {
                $publications = --$package->pivot->publications;
            }
        } else {
            return ApiAnswerService::errorAnswer('You dont have active package', 404);
        }

        $post->update(['is_active' => true]);
        $user->packages()->sync([$package->id => [
            'publications' => $publications
        ]]);

        return ApiAnswerService::successfulAnswerWithData(
            $post->toArray() + ['publications_lost' => $publications]);
    }
}
