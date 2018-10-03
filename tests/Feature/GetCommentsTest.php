<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Comment;


class GetCommentsTest extends TestCase
{
    use RefreshDatabase;

    const URL = '/api/comments';

    /** @test */
    public function it_returns_an_empty_list_if_no_comments_in_system()
    {
        $this->get(self::URL)
            ->assertStatus(200)
            ->assertExactJson(['data' => []]);
    }

    /** @test */
    public function it_gets_a_list_of_comments()
    {
        $this->withoutExceptionHandling();
        $comment = factory(Comment::class)->create();

        $this->get(self::URL)
            ->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonStructure(['data' => ['*' => [
                'name', 'comment', 'parent_id'
            ]]])
            ->assertJsonFragment(['name' => $comment->name]);
    }

    /** @test */
    public function children_are_nested_under_parents()
    {
        $comment1 = factory(Comment::class)->create();
        $comment2 = factory(Comment::class)->create([
            'parent_id' => $comment1->id
        ]);

        $this->get(self::URL)
            ->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonStructure(['data' => ['*' => [
                'children' => ['*' => [
                    'name', 'comment', 'parent_id'
                ]]
            ]]])
            ->assertJsonFragment(['name' => $comment1->name])
            ->assertJsonFragment(['name' => $comment2->name]);
    }

    /** @test */
    public function children_are_nested_at_depth()
    {
        $comment1 = factory(Comment::class)->create();
        $comment2 = factory(Comment::class)->create([
            'parent_id' => $comment1->id
        ]);
        $comment3 = factory(Comment::class)->create([
            'parent_id' => $comment2->id
        ]);

        $this->get(self::URL)
            ->assertJsonStructure(['data' => ['*' => [
                'children' => ['*' => [ 'children' ]]
            ]]])
            ->assertJsonFragment(['name' => $comment1->name])
            ->assertJsonFragment(['name' => $comment2->name])
            ->assertJsonFragment(['name' => $comment3->name]);
    }

}
