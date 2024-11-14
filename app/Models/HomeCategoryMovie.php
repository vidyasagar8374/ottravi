<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCategoryMovie extends Model
{
    use HasFactory;

    public function movie(){
        return $this->hasOne(Movie::class, 'id', 'movie_id');

    }
}
