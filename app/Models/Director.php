<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Director extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_directors_tmdb',
        'name',
        'image',
    ];

    public function titles(): BelongsToMany {
        return $this->belongsToMany(Title::class);
    }
}
