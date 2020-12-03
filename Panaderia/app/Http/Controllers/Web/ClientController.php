<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $clients = Client::all()->map(function ($client) {
            return (object) [
                'id'      => $client->id,
                'name'    => $client->name,
                'phone'    => $client->phone,
                'direction'    => $client->direction,
            ];
        })->paginate();
        return view('admin.client.index',
        [
            'clients' => $clients
        ]);

    }

}
