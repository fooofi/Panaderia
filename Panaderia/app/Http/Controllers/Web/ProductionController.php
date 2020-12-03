<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Production;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



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
                'name' => $production->name,
                'product' => $production->product->name,
                'quantity' => $production->quantity,
                'decrease' => $production->decrease,
                'date'      => $production->date_create(),
                'quantity_in_quintals' => $production->quantity_in_quintals,
                'efective_decrease' => $production->efective_decrease,
                'cost' => $production->cost,
            ];
        })->paginate();
        return view('admin.production.index', [
            'productions' => $productions,
        ]);

    }
    public function create()
    {
        $user = auth()->user();
        $products = Product::all()->map(function($product){
            return (object) [
                'id' => $product->id,
                'name' => $product->name,
            ];
        });
        return view('admin.production.create', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createProduction($request->all());
        return redirect()->route('admin.production');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'product'              => ['required', 'integer', 'exists:products,id'],
            'name'              => ['required', 'string', 'max:255'],
            'quantity'             => ['required', 'integer'],
            'decrease'             => ['required', 'integer'],
            'quantity_in_quintals' => ['required', 'integer'],
            ]);
    }

    protected function createProduction(array $data)
    {
        $data['quantity'] = $data['quantity'] == 0 ? 1 : $data['quantity'];

        $costProduction = Product::find($data['product'])->get_cost() * $data['quantity'];

        $production = Production::create([
            'product_id'           => $data['product'],
            'decrease'             => $data['decrease'],
            'name'                 => $data['name'],
            'quantity'             => $data['quantity'],
            'quantity_in_quintals' => $data['quantity_in_quintals'],
            'cost'                 => $costProduction
        ]);
        
    }

    public function production_delete(Request $request)
    {
        $data = $request->all();
        $production = Production::find($data['id']);
        $production->delete();

        return redirect()->route('admin.production');
    }

}
