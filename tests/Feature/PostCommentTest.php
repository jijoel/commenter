<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Comment;


class PostCommentTest extends TestCase
{
    use RefreshDatabase;

    const URL = '/api/comments';

    /**
     * @test
     * @dataProvider getDataToValidate
     */
    public function posted_comment_must_include_valid_data($data)
    {
        $this->postJson(self::URL, $data)
            ->assertStatus(422);
    }

    public function getDataToValidate()
    {
        $okName = 'x';
        $longName = str_repeat('x', 256);
        $okComment = str_repeat('x',10);
        $shortComment = str_repeat('x',9);

        return [
            [[]],
            [['name'=>$okName]],
            [['comment'=>$okComment]],
            [['name'=>$longName, 'comment'=>$okComment]],
            [['name'=>$okName, 'comment'=>$shortComment]],
        ];
    }

    /** @test */
    public function a_comment_can_be_posted()
    {
        $this->withoutExceptionHandling();
        $data = factory(Comment::class)->make()->toArray();

        $this->postJson(self::URL, $data)
            ->assertStatus(201)
            ->assertJsonFragment(['name' => $data['name']]);
    }

    /** @test */
    public function a_comment_can_be_a_child_of_another_comment()
    {
        $this->withoutExceptionHandling();
        $parent = factory(Comment::class)->create();
        $data = factory(Comment::class)->make([
            'parent_id' => $parent->id
        ])->toArray();

        $this->postJson(self::URL, $data)
            ->assertStatus(201)
            ->assertJsonFragment(['name' => $data['name']])
            ->assertJsonFragment(['parent_id' => $parent->id]);
    }

    /** @test */
    public function comment_deeper_than_3_levels_is_assigned_to_parent()
    {
        $l1 = factory(Comment::class)->create();
        $l2 = factory(Comment::class)->create([
            'parent_id' => $l1->id
        ]);
        $l3 = factory(Comment::class)->create([
            'parent_id' => $l2->id
        ]);
        $new = factory(Comment::class)->make([
            'parent_id' => $l3->id
        ])->toArray();

        $this->postJson(self::URL, $new)
            ->assertStatus(201)
            ->assertJsonFragment(['name' => $new['name']])
            ->assertJsonFragment(['parent_id' => $l2->id]);
    }

    /** @test */
    public function a_child_comment_must_have_a_valid_parent()
    {
        $data = factory(Comment::class)->make([
            'parent_id' => 20
        ])->toArray();

        $this->postJson(self::URL, $data)
            ->assertStatus(422);
    }

}

