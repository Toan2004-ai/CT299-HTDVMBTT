<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Flight;
use App\Models\Order;
use App\Models\FoodOrder;
use Illuminate\Support\Facades\Auth;

class FinalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Lấy thông tin ghế ngồi của người dùng
        $seats = Seat::where('user_id', $user->id)->get();

        // Lấy thông tin chuyến bay từ ghế ngồi
        $flight = Flight::where('id', $seats->first()->flight_id ?? null)->first();
        
        // Lấy order_id gần nhất của user
        $order = Order::where('user_id', $user->id)->latest()->first();

if ($order) {
    $food_orders = FoodOrder::where('order_id', $order->id)
        ->join('foods', 'food_order.food_id', '=', 'foods.id')
        ->select('foods.name', 'food_order.quantity', 'food_order.price')
        ->get();
} else {
    $food_orders = collect(); // Trả về collection rỗng nếu không có order


// Tính tổng tiền thức ăn
$food_total = $food_orders->sum(fn($food) => $food->quantity * $food->price);

}

        // Tính tổng tiền ghế ngồi
        $seat_total = $seats->sum(function ($seat) {
            return $seat->seat_type == 'business' ? 600 : 200;
        });

        // Tính tổng tiền thức ăn
        $food_total = $food_orders->sum(function ($food) {
            return (int) $food->quantity * (float) $food->price;
        });
        

        // Tổng tiền phải thanh toán
        $total_price = $seat_total + $food_total;

        return view('customer.final.index', compact('user', 'seats', 'flight', 'food_orders', 'seat_total', 'food_total', 'total_price'));
    }
}
