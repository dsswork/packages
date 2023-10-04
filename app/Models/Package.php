<?php

namespace App\Models;

use App\Traits\ActiveScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory, ActiveScopeTrait;

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'bool'
    ];

    protected $fillable = ['name', 'price', 'publications', 'is_active'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
