<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\ParentIdResolver;
use App\Comment;


class ParentIdResolverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_null_if_no_parent_provided()
    {
        $test = new ParentIdResolver();
        $this->assertEquals(null, $test->get(null));
    }

    /** @test */
    public function it_returns_id_if_in_valid_depth()
    {
        $parent = factory(Comment::class)->create();

        $test = new ParentIdResolver();
        $this->assertEquals($parent->id, $test->get($parent->id));
    }

    /** @test */
    public function it_returns_parent_id_if_past_valid_depth()
    {
        $l1 = factory(Comment::class)->create();
        $l2 = factory(Comment::class)->create(['parent_id'=>$l1->id]);
        $l3 = factory(Comment::class)->create(['parent_id'=>$l2->id]);

        $test = new ParentIdResolver();
        $this->assertEquals($l2->id, $test->get($l3->id));
    }

}
