<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
// use App\Models\Organization;
use Illuminate\Support\Facades\Log;
use App\Models\Production;
use App\Models\Order;
use App\Models\OrderProduction;

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
        })
        ->filter(function($production){
            return $production->created_at->isToday();
        })
        ->paginate();
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
        })
        ->filter(function($order){
            return $order->created_at->isToday();
        })
        ->paginate();
        return view('admin.dashboard', [
            'productions' => $productions,
            'orders' => $orders,
            'countProduction' => $productions->count(),
            'countOrder' => $orders->count(),
            'totalIncome' => 1,
        ]);
    }

}
