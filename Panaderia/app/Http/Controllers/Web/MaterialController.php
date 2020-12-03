<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\TypeMeasure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
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
        $materials = RawMaterial::all()->map(function ($material) {
            return (object) [
                'id'      => $material->id,
                'name'    => $material->name,
                'stock'   => $material->stock,
                'measure' => $material->type_measure->name,
                'cost'    => $material->cost,
            ];
        })->paginate();
        return view('admin.material.index',[
            'materials' => $materials
        ]);

    }
    public function create()
    {
        $user = auth()->user();

        $measures = TypeMeasure::all()->map(function ($measure){
            return (object) [
                'id' => $measure->id,
                'name' => $measure->name,
            ];
        });
        return view('admin.material.create',[
            'measures' => $measures
        ]);
    }

    public function material_delete(Request $request)
    {
        $data = $request->all();
        $material = RawMaterial::find($data['id']);
        $material->delete();

        return redirect()->route('admin.material');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createMaterial($request->all());
        return redirect()->route('admin.material');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'    => ['required', 'string', 'max:255'],
            'stock'   => ['required', 'integer'],
            'measure' => ['required', 'integer'],
            'cost'    => ['required', 'integer'],
        ]);
    }

    protected function createMaterial(array $data)
    {
        $product = RawMaterial::create([
            'name'            => $data['name'],
            'stock'           => $data['stock'],
            'type_measure_id' => $data['measure'],
            'cost'            => $data['cost'],
            
        ]);
    }
}
