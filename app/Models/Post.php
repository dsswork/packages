<?php

namespace App\Models;

use App\Traits\ActiveScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, ActiveScopeTrait;

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $fillable = ['title', 'body', 'user_id', 'is_active', 'published_at'];
}
