<?php

namespace app\Http\Resources\Post;

use App\Http\Resources\PaginateCollection;
use Illuminate\Http\Request;

class PostCollection extends PaginateCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
