<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPurchaseMovie extends Model
{
    use HasFactory;
    protected $fillable = ['movie_id', 'purchase_date', 'expire_date', 'is_active','user_id','total_length','paused_length'];
    public function moviedata(){
        return $this->hasOne(Movie::class,'id', 'movie_id');
    }
    
}
