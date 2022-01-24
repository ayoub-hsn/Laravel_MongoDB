<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function new(){
        return $this->belongsTo(News::class);
    }
    
}
