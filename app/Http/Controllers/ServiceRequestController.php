<?php

namespace App\Http\Controllers;

use App\Enums\ServiceRequestStateEnum;
use App\Enums\TicketStateEnum;
use App\Models\ServiceRequest;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', ServiceRequest::class);

        $service_requests = Auth::user()->service_requests()
            ->orderby('updated_at', 'desc')
            ->paginate(5);

        return view('service_requests.index', [
            'service_requests' => $service_requests,
        ]);
    }

    public function index_open()
    {
        $this->authorize('index_open_closed', ServiceRequest::class);

        $service_requests = ServiceRequest::where('state', ServiceRequestStateEnum::ASSIGNED)
            ->orderby('updated_at', 'desc')
            ->paginate(5);

        return view('service_requests.index', [
            'service_requests' => $service_requests,
        ]);
    }

    public function index_closed()
    {
        $this->authorize('index_open_closed', ServiceRequest::class);

        $service_requests = ServiceRequest::where('state', ServiceRequestStateEnum::CLOSED)
            ->orderby('updated_at', 'desc')
            ->paginate(5);

        return view('service_requests.index', [
            'service_requests' => $service_requests,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         # TODO: Solve caching problem when going back after this request

        $this->authorize('create', ServiceRequest::class);

        if ($request->has('submit_new_request')) {
            $validated = $request->validate([
                'title' => 'required|string',
                'ticket_id' => 'required',
                'technician_id' => 'required',
                'city_admin_id' => 'required'
            ]);

            $ticket = Ticket::where('id', $validated['ticket_id'])->first();

            $data = new ServiceRequest([
                'city_admin_id' => $validated['city_admin_id'],
                'technician_id' => $validated['technician_id'],
                'ticket_id' => $validated['ticket_id'],
                'state' => 0,
                'title' => $validated['title'],
            ]);
            $data->save();

            # Change state of the ticket
            $ticket->setState(TicketStateEnum::WIP);
            $ticket->save();

            return redirect(route('service_requests.show', $data->id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $sr_id
     * @return \Illuminate\Http\Response
     */
    public function show($sr_id)
    {
        # Any user besides citizens can view the request,
        # even a technician that is not assigned to the request
        $this->authorize('viewAny', ServiceRequest::class);

        $sr = ServiceRequest::find($sr_id);

        if (!$sr)
        {
            abort(404, 'Ticket not found.');
        }

        $sorted_comments = $sr->comments->sortByDesc(function ($created_at) {
            return $created_at;
        })->values()->all();


        return view('service_requests.show', [
            'sr' => $sr,
            'comments' => $sorted_comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        # Admin can edit: Technician
        # Technician can edit: state, costs, exp. date, notes
        $sr = ServiceRequest::find($id);
        $this->authorize('update', $sr);

        return view('service_requests.edit', [
            'sr' => $sr,
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
        $sr = ServiceRequest::find($id);
        $this->authorize('update', $sr);

        if ($request->user()->getRole() != User::getRoleId('technician'))
        {
            $validated = $request->validate([
                'technician_id' => 'exists:App\Models\User,id',
                'notes'         => 'string|nullable']);
            $sr->technician_id = $validated['technician_id'];
            $sr->notes = $validated['notes'];
        }
        else {
            $validated = $request->validate([
                'state'         =>  Rule::in([ServiceRequestStateEnum::ASSIGNED->value,
                                              ServiceRequestStateEnum::CLOSED->value]),
                'costs'         => 'numeric|nullable',
                'expected_date' => 'date|nullable',
                'notes'         => 'string|nullable']);
            $sr->setState(ServiceRequestStateEnum::from($validated['state']));
            $sr->costs_usd = $validated['costs'];
            $sr->expected_date_of_resolution = $validated['expected_date'];
            $sr->notes = $validated['notes'];
        }

        $sr->save();

        return redirect(route('service_requests.show', $id));
    }
}
