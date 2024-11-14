<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function ottdetails(){
        return $this->hasMany(ottdataList::class, 'movie_id', 'id');
    }
}
