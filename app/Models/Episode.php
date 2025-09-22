<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_id',
        'name',
        'image',
        'episode_number',
        'season',
        'overview',
        'duration',
    ];
    
    public function titles(): BelongsTo {
        return $this->belongsTo(Title::class);
    }
}
