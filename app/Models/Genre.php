<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public function tracks()
    {
        // tracks.genre_id is the foreign key column
        return $this->hasMany(Track::class);
    }
}
