<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $tickets = $user->isAdmin? Ticket::latest()->get() : $user->tickets;

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        if ($request->file('attachments')) {
            $this->storeAttachment($request, $ticket);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->except('attachment'));

        if($request->has('status')){
            $ticket->user->notify(new TicketUpdatedNotification($ticket));
        }

        if($request->file('attachment')){
            
            //delete old attachment
            if($ticket->attachments){
                Storage::disk('public')->delete($ticket->attachments);
            }

            $this->storeAttachment($request, $ticket);
           
        }

        return redirect()->route('ticket.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->back();
    }

    /**
     * Save the uploaded resource to storage
     */
    protected function storeAttachment($request, $ticket){
        $file = $request->file('attachment'); 
        $ext = $file->extension();
        $contents = file_get_contents($file);
        $filename = Str::random();
        $path = "attachments/$filename.$ext";

        // save uploaded image
        Storage::disk('public')->put($path, $contents);
        $ticket->update(['attachment' => $path]);
    }
}
