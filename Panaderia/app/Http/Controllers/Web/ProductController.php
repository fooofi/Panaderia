<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\TypeMeasure;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
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

        $pros = collect(Product::paginate()->items());

        $products = $pros->map(function ($product) {
            return (object) [
                'id'            => $product->id,
                'name' => $product->name,
                'measure'  => $product->measure,
                'materials'           => $product->materials,
                'cost'          => $product->cost,
            ];
        });


        return view('admin.product.index', [
            'products' => $products,
        ]);
    }
    public function create()
    {
        $user = auth()->user();

        $materials = RawMaterial::all()->map(function ($rawMaterial) {
            
            return (object) [
                'id' => $rawMaterial->id,
                'name' => $rawMaterial->name,
                'stock' => $rawMaterial->stock,
                'type_measure' => $rawMaterial->measure->name,
                'cost' => $rawMaterial->cost,
            ];
        });

        $measures = TypeMeasure::all();
        
        return view('admin.product.create',
        [
            'materials' => $materials,
            'measures'  => $measures
        ]);
    }

    public function storage()
    {

    }

}
