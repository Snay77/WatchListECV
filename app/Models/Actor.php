<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_casts_tmdb',
        'name',
        'image',
        'pseudo',
    ];

    public function titles(): BelongsToMany {
        return $this->belongsToMany(Movie::class);
    }
}
