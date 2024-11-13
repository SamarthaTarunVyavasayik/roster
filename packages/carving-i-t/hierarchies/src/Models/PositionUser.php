<?php

namespace CarvingIT\Hierarchies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PositionUser extends Model
{
    use HasFactory;
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
