<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Production;

use Illuminate\Support\Facades\Log;

class ProductionController extends Controller
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

        $productions = Production::all()->map(function ($production) {
            
            return (object) [
                'id' => $production->id,
            ];
        })->paginate();
        return view('admin.production.index', [
            'productions' => $productions,
        ]);

    }
    public function create()
    {
        $user = auth()->user();
        return view('admin.production.create');
    }

}
