<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ticket = Ticket::where('title', 'Broken lamp')->first();
        $request = new ServiceRequest([
            'city_admin_id' => User::where('email', 'zoe@email.com')->first()->id,
            'technician_id' => User::where('email', 'jack@email.com')->first()->id,
            'ticket_id' => $ticket->id,
            'state' => 0,
            'title' => 'SR1 for ticket #1',
        ]);
        $request->save();
    }
}
