<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $t = Ticket::where('title', 'Broken lamp')->first();
        $t->comments()->save(new Comment([
            'author_id' => User::where('email', 'mia@email.com')->first()->id,
            'text' => "+1 It's dangerous to walk through this street at night"
        ]));

        $s = $t->service_requests()->first();
        $s->comments()->save(new Comment([
            'author_id' => User::where('email', 'jack@email.com')->first()->id,
            'text' => "Waiting for a light bulb to arrive, we didn't have any in stock",
        ]));
    }
}
