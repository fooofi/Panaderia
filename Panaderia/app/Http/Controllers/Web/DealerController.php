<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Dealer;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\Rut;

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

    public function create()
    {
        $user = auth()->user();

        return view('admin.dealer.create');
    }

    public function dealer_delete(Request $request)
    {
        $data = $request->all();
        $dealer = Dealer::find($data['id']);
        $dealer->delete();

        return redirect()->route('admin.dealer');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createDealer($request->all());
        return redirect()->route('admin.dealer');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'    => ['required', 'string', 'max:255'],
            'lastname'   => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string' , 'max:255'],
            'rut'    => ['required', 'string', 'max:255', new Rut()],
        ]);
    }

    protected function createDealer(array $data)
    {
        $product = Dealer::create([
            'name'            => $data['name'],
            'lastname'           => $data['lastname'],
            'phone' => $data['phone'],
            'email'            => $data['email'],
            'rut'            => $data['rut'],
        ]);
    }

}
