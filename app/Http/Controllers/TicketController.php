<?php

namespace App\Http\Controllers;

use App\Enums\ServiceRequestStateEnum;
use App\Enums\TicketStateEnum;
use App\Models\Comment;
use App\Models\PhotoAttachment;
use App\Models\ServiceRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Auth::user()->tickets()
            ->orderby('updated_at', 'desc')
            ->paginate(5);

        return view('tickets.index', ['tickets' => $tickets]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_open()
    {
        $tickets = Ticket::where('state', '!=', TicketStateEnum::FIXED)
            ->orderby('updated_at', 'desc')
            ->paginate(5);

        return view('tickets.index_open', ['tickets' => $tickets]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_closed()
    {
        $tickets = Ticket::where('state',TicketStateEnum::FIXED)
            ->orderby('updated_at', 'desc')
            ->paginate(5);

        return view('tickets.index_closed', ['tickets' => $tickets]);
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
            'description' => 'required|string',
        ]);

        $ticket_id = $request->user()->tickets()->create($validated)->id;

        # TODO: Add validators
        if ($request->hasFile('photo_attachments'))
        {
            foreach ($request->file('photo_attachments') as $photo)
            {
                $path = $photo->store('public/photo_attachments/'.$ticket_id);

                $data = new PhotoAttachment([
                    'ticket_id' => $ticket_id,
                    'filepath' => $path,
                ]);
                $data->save();
            }
        }

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

            $ticket->setState(TicketStateEnum::FIXED);
            $ticket->save();

            # TODO: Is this the right way? (and effective)
            foreach ($ticket->service_requests as $sr)
            {
                $sr->setState(ServiceRequestStateEnum::CLOSED);
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
