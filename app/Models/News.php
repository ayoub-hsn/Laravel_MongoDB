<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function dislikes(){
        return $this->hasMany(Dislike::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function scopeLastNews(Builder $query){
        $query->orderBy(STATIC::UPDATED_AT,'desc');
    }

    
}
