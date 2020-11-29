<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
// use App\Models\Organization;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
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
        return view('admin.dashboard');
        // if ($user->hasRole('manager')) {
        //     return $this->manager();
        // }
        // if ($user->hasRole('executive')) {
        //     return $this->executive();
        // }
    }

    protected function admin()
    {

        
    }

    protected function manager()
    {
        return view('manager.dashboard', []);
    }

    protected function executive()
    {
        return view('executive.dashboard', []);
    }
}
