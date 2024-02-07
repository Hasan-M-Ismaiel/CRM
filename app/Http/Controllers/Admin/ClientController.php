<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return view('admin.clients.index', [
            'clients' => $clients,
            'page' => 'Clients List'
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clients.create', [
            'page' => 'Creating client',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        
        return redirect()->route('admin.clients.index')->with('message', 'the client has been created sucessfully');;
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->with('projects');
        return view('admin.clients.show', [
            'client' => $client,
            'page' => 'Showing client',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('admin.clients.edit', [
            'client' => $client,
            'page' => 'Editing client',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        
        return redirect()->route('admin.clients.index')->with('message', 'the client has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index')->with('message','the client has been deleted successfully');
    }
}
