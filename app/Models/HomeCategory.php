<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCategory extends Model
{
    use HasFactory;

    public function categoryname(){
        return $this->hasMany(HomeCategoryMovie::class, 'home_category_id', 'id');

    }
    
}
