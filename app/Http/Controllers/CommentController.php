<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CommentResource;
use App\Http\Requests\CommentRequest;
use App\Services\ParentIdResolver;
use App\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $found = Comment::whereNull('parent_id')
            ->orderBy('created_at')
            ->with('children')
            ->get();

        return CommentResource::collection($found);
    }

    public function post(CommentRequest $request, ParentIdResolver $parentId)
    {
        $data = $request->input();
        $data['parent_id'] = $parentId->get(array_get($data, 'parent_id'));

        return new CommentResource(Comment::create($data));
    }

}
