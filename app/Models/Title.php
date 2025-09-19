<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Title extends Model
{
    use HasFactory;

    public function genres(): BelongsToMany {
        return $this->belongsToMany(Genre::class);
    }

    public function casts(): BelongsToMany {
        return $this->belongsToMany(Actor::class);
    }
    
    public function directors(): BelongsToMany {
        return $this->belongsToMany(Director::class);
    }
}
