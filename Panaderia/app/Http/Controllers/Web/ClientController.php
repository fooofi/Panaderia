<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function create()
    {
        $user = auth()->user();

        return view('admin.client.create');
    }

    public function client_delete(Request $request)
    {
        $data = $request->all();
        $client = Client::find($data['id']);
        $client->delete();

        return redirect()->route('admin.client');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createClient($request->all());
        return redirect()->route('admin.client');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'    => ['required', 'string', 'max:255'],
            'direction'   => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function createClient(array $data)
    {
        $product = Client::create([
            'name'            => $data['name'],
            'direction'           => $data['direction'],
            'phone' => $data['phone'],
        ]);
    }

}
