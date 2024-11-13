<?php

namespace CarvingIT\Hierarchies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public function reports(){
        return $this->hasMany(Position::class,'reports_to');
    }

    public function positionusers(){
        return $this->hasMany(PositionUser::class);
    }
}
