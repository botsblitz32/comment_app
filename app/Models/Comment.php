<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'comment', 'comment_parent_id'];

    public function commentReplies(){
        return $this->hasMany('App\Models\Comment', 'comment_parent_id')->orderBy('created_at', 'desc');
    }
}
