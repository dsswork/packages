<?php

namespace App\Http\Resources\Package;

use App\Http\Resources\PaginateCollection;
use Illuminate\Http\Request;

class PackageCollection extends PaginateCollection
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
