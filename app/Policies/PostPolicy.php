<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function activate(User $user, Post $post):bool
    {
        return $post->user_id===$user->id;
    }
}
