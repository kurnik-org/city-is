<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ServiceRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Ticket::class);

        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Ticket::class);

        $validated = $request->validate([
            'title' => 'required|string|max:128',
            'description' => 'required|string'
        ]);

        $ticket_id = $request->user()->tickets()->create($validated)->id;

        return redirect(route('tickets.show', $ticket_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $ticket_id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);

        if (!$ticket)
        {
            abort(404, 'Ticket not found.');
        }

        $sorted_comments = $ticket->comments->sortByDesc(function ($created_at) {
            return $created_at;
        })->values()->all();


        return view('tickets.show', [
            'ticket' => $ticket,
            'comments' => $sorted_comments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('submit_close_ticket')) {
            $ticket = Ticket::find($id);

            $ticket->state = Ticket::getStateId('fixed');
            $ticket->save();

            # TODO: Is this the right way? (and effective)
            foreach ($ticket->service_requests as $sr)
            {
                $sr->state = 1; # TODO: Method for getting state NR? ENUM?
                $sr->save();
            }

            $sorted_comments = $ticket->comments->sortByDesc(function ($created_at) {
                return $created_at;
            })->values()->all();


            return view('tickets.show', [
                'ticket' => $ticket,
                'comments' => $sorted_comments,
            ]);
        }
    }
}
