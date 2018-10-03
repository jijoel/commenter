<?php

namespace App\Services;

use App\Comment;

class ParentIdResolver
{
    /**
     * Resolve the actual id of the parent comment,
     * based on a given parent id, and these rules:
     *
     * - If we received null, there is no parent (return null)
     * - If the parent would put us deeper than three
     *   levels, return the id of its parent.
     * - Otherwise, return the parent id given
     *
     * @param  integer  $id   The id to check
     * @return integer        The resolved parent's id
     */
    public function get($id)
    {
        if ($id == null)
            return null;

        $parent = Comment::find($id);
        if (optional($parent->parent)->parent)
            return $parent->parent_id;

        return $id;
    }}
