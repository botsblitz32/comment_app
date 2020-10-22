<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function all();

    public function create(array $data);
}
