<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRawMaterial;
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

        $pros = Product::all();

        $products = $pros->map(function ($product) 
        {
            $materials = $product->raw_materials->map(function($material) use ($product)
            {
                $proMat = ProductRawMaterial::where('product_id', $product->id )
                    ->get()
                    ->filter(function($proMat) use ($material){
                        return $proMat->raw_material_id == $material->id;
                })->first();

                return (object) [
                'id'   => $material->id,
                'name' => $material->name,
                'quantity' => $proMat->quantity
                ];
            });

            return (object) [
                'id'            => $product->id,
                'name'          => $product->name,
                'measure'       => $product->type_measure->name,
                'materials'     => $materials,
                'cost'          => $product->get_cost(),
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
                'type_measure' => $rawMaterial->type_measure->name,
                'cost' => $rawMaterial->cost,
            ];
        });

        $measures = TypeMeasure::all()->map(function ($measure){
            return (object) [
                'id' => $measure->id,
                'name' => $measure->name,
            ];
        });
        
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