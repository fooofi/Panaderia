<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRawMaterial;
use App\Models\RawMaterial;
use App\Models\TypeMeasure;
use App\Models\TypeProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
                'measure' => $material->type_measure->name,
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

        $types_products = TypeProduct::all()->map(function ($type){
            return (object) [
                'id' => $type->id,
                'name' => $type->name,
            ];
        });
        
        return view('admin.product.create',
        [
            'materials' => $materials,
            'measures'  => $measures,
            'types_product' => $types_products,
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createProduct($request->all());
        return redirect()->route('admin.product');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'product_name'    => ['required', 'string', 'max:255'],
            'product_measure' => ['required', 'integer'],
            'product_type'    => ['required', 'integer'],
        ]);
    }

    protected function createProduct(array $data)
    {
        $product = Product::create([
            'name'            => $data['product_name'],
            'type_product_id' => $data['product_type'],
            'type_measure_id' => $data['product_measure'],
        ]);
        
        $materials = RawMaterial::all()->map(function ($material){
            return (object) [
                'id' => $material->id,
                'name' => $material->name,
            ];
        });

        foreach ($materials as $material) 
        {
            
            if (isset($data["material_checkbox-" . $material->id]) && $data["material_checkbox-" . $material->id] == "on" && $data["material_checkbox-" . $material->id] != null) 
            {
                if ($data["product_quantity-" . $material->id] != null ) 
                {
                    ProductRawMaterial::Create([
                        'product_id' => $product->id,
                        'raw_material_id' => $material->id,
                        'quantity' => $data["product_quantity-" . $material->id],
                    ]);
                }else{
                    ProductRawMaterial::Create([
                        'product_id' => $product->id,
                        'raw_material_id' => $material->id,
                        'quantity' => 1,
                    ]);
                }
            }
        }

    }

    public function product_delete(Request $request)
    {
        $data = $request->all();
        $product = Product::find($data['id']);
        $product->delete();

        return redirect()->route('admin.product');
    }

}
