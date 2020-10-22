<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function all()
    {
        // We repeat the relationship here to be able to get up to level 3 nested replies
        return Comment::with('commentReplies.commentReplies.commentReplies')->where('comment_parent_id', 0)->orderBy('created_at','desc')->get();
    }

    public function create(array $data) {
        return Comment::create($data);
    }

}