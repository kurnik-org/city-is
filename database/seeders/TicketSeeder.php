<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chris = User::all()->where('email', 'chris@email.com')->first();
        $mia = User::all()->where('email', 'mia@email.com')->first();

        $lamp = new Ticket(
            [
                'title' => 'Broken lamp',
                'description' => 'Street: Coastline Avenue.'
            ]
        );
        $lamp->author_id = $chris->id;
        $lamp->save();

        $litter = new Ticket(
            [
                'title' => 'Litter all over the main square',
                'description' => "I just can't live in this city anymore when people are making such a mess everywhere."
            ]
        );
        $litter->author_id = $chris->id;
        $litter->save();

        $sign = new Ticket(
            [
                'title' => 'Missing road sign',
                'description' => "I was driving my kid to school and as I was turning onto Art Lane, "
                    . "I realized the sign was missing."
            ]
        );
        $sign->author_id = $mia->id;
        $sign->save();
    }
}
