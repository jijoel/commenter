<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Comment;


class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_have_a_parent()
    {
        $parent = factory(Comment::class)->create();
        $child = factory(Comment::class)->create([
            'parent_id' => $parent->id
        ]);

        // use a field in parent to avoid wasRecentlyCreated error
        $this->assertEquals($parent->name, $child->parent->name);
    }

    /** @test */
    public function it_can_have_children()
    {
        $parent = factory(Comment::class)->create();
        $child = factory(Comment::class)->create([
            'parent_id' => $parent->id
        ]);

        // use a field in parent to avoid wasRecentlyCreated error
        $this->assertEquals($child->name, $parent->children[0]->name);
    }

    /** @test */
    public function we_can_add_a_comment()
    {
        $test = factory(Comment::class)->make();

        // This will throw mass assignment exception
        // for any non-approved fields
        Comment::create($test->toArray());

        $this->assertCount(1, Comment::all());
    }
}
