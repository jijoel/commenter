<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CommentResource;
use App\Comment;

class CommentController extends Controller
{
    public function index()
    {
        return CommentResource::collection(
            Comment::whereNull('parent_id')
                ->with('children')->get()
        );
    }

    public function post(Request $request)
    {
        return [];
    }
}
