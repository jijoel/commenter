<?php

use Illuminate\Database\Seeder;

use App\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $l1 = factory(Comment::class)->create();
        $l2 = factory(Comment::class,rand(1,5))->create([
            'parent_id' => $l1->id
        ]);
        foreach ($l2 as $subitem) {
            factory(Comment::class,rand(1,5))->create([
                'parent_id' => $subitem->id
            ]);
        }

    }
}
