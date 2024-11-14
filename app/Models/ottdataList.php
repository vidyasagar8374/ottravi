<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ottdataList extends Model
{
    use HasFactory;
    public function ott(){
        return $this->hasOne(ottList::class, 'id', 'ott_id');
    }
}
