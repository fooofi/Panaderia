<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Dealer;
use Illuminate\Support\Facades\Log;

class DealerController extends Controller
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
        $dealers = Dealer::all()->map(function ($ddealer) {
            return (object) [
                'id'      => $ddealer->id,
                'name'    => $ddealer->name,
                'lastname'   => $ddealer->lastname,
                'rut' => $ddealer->rut,
                'phone'    => $ddealer->phone,
                'email'    => $ddealer->email,
            ];
        })->paginate();
        return view('admin.dealer.index',
        [
            'dealers' => $dealers
        ]);

    }

}
