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

    public function userAttributes(){
        return empty($this->user_attributes) ? null : json_decode($this->user_attributes);
    }
}
