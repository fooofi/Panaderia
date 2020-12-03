<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\OrderProduction;
use App\Models\Production;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
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
        $orders = Order::all()->map(function ($order) {
            $productions = $order->productions->map(function($production) use ($order)
            {
                $ordPro = OrderProduction::where('order_id', $order->id )
                    ->get()
                    ->filter(function($ordPro) use ($production){
                        return $ordPro->production_id == $production->id;
                })->first();

                return (object) [
                'id'   => $production->id,
                'production_name' => $production->name,
                'product_name' => $production->product->name,
                'measure' => $production->product->type_measure->name,
                'quantity' => $ordPro->quantity
                ];
            });
            return (object) [
                'id' => $order->id,
                'name' => $order->name,
                'quantity' => $order->quantity,
                'date'      => $order->date_create(),
                'client' => $order->client->name,
                'direction' => $order->client->direction,
                'dealer' => $order->dealer->name,
                'detail' => $order->detail,
                'total_to_pay' => $order->total_to_pay,
                // 'decrease' => $order->decrease,
                'productions' => $productions
            ];
        })->paginate();
        return view('admin.order.index', [
            'orders' => $orders,
        ]);

    }
    public function create()
    {
        $clients = Client::all()->map(function ($client) {
            return (object) [
                'id' => $client->id,
                'name' => $client->name,
            ];
        });

        $dealers = Dealer::all()->map(function ($dealer) {
            return (object) [
                'id' => $dealer->id,
                'name' => $dealer->name,
            ];
        });

        // TODO: VALIDAR logica para descontar stock 
        $productions = Production::all()->map(function ($production) {
            return (object) [
                'id' => $production->id,
                'name' => $production->product->name,
                'stock' => $production->stock(),
                'measure' => $production->product->type_measure->name,
                'created_at' => $production->created_at
            ];
        })->filter(function($production){
            return $production->stock > 0 && $production->created_at->isToday();
        });

        $user = auth()->user();
        return view('admin.order.create',[
            'productions' => $productions,
            'clients'     => $clients,
            'dealers'     => $dealers,
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createOrder($request->all());
        return redirect()->route('admin.order');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'client'       => ['required', 'integer'],
            'dealer'       => ['required', 'integer'],
            'total_to_pay' => ['required', 'integer'],
        ]);
    }

    protected function createOrder(array $data)
    {
        $order = Order::create([
            'client_id'    => $data['client'],
            'dealer_id'    => $data['dealer'],
            'user_id'      => auth()->user()->id,
            'detail'       => $data['detail'],
            // 'decrease'     => $data['decrease'],
            'total_to_pay' => $data['total_to_pay'],
        ]);
        
        $productions = Production::all()->map(function ($production) {
            return (object) [
                'id' => $production->id,
                'name' => $production->product->name,
                'stock' => $production->stock(),
                'measure' => $production->product->type_measure->name,
                'created_at' => $production->created_at
            ];
        })->filter(function($production){
            return $production->stock > 0 && $production->created_at->isToday();
        });

        foreach ($productions as $production) 
        {
            
            if (isset($data["production_checkbox-" . $production->id]) && $data["production_checkbox-" . $production->id] == "on" && $data["production_checkbox-" . $production->id] != null) 
            {
                if (isset($data["production_quantity-" . $production->id]) && $data["production_quantity-" . $production->id] != null ) 
                {
                    OrderProduction::Create([
                        'production_id' => $production->id,
                        'order_id' => $order->id,
                        'quantity' => $data["production_quantity-" . $production->id],
                    ]);
                }else{
                    OrderProduction::Create([
                        'production_id' => $production->id,
                        'order_id' => $order->id,
                        'quantity' => 1,
                    ]);
                }
            }
        }
    }

    public function order_delete(Request $request)
    {
        $data = $request->all();
        $order = Order::find($data['id']);
        $order->delete();

        return redirect()->route('admin.order');
    }

}