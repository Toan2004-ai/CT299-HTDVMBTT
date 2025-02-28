<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    // Lấy danh sách món ăn từ database
    public function index()
    {
        $foodItems = Food::all(); // Lấy dữ liệu từ database
        return view('admin.food.index', compact('foodItems'));
    }

    // Lưu món ăn vào database
    public function store(Request $request)
{
    $order = Order::create([
        'user_id' => auth()->id(),
        'total_price' => 0, // Khởi tạo tổng tiền = 0
        'status' => 'pending'
    ]);

    $totalPrice = 0;

    if ($request->has('foods')) {
        foreach ($request->foods as $foodId => $quantity) {
            $food = Food::find($foodId);
            if ($food) {
                // Thêm món ăn vào order
                $order->foods()->attach($foodId, [
                    'quantity' => $quantity,
                    'price' => $food->price * $quantity
                ]);

                // Tính tổng tiền
                $totalPrice += $food->price * $quantity;
            }
        }
    }

    // Cập nhật tổng tiền order
    $order->update(['total_price' => $totalPrice]);

    return response()->json($order);
}
    // Lưu đơn hàng vào database thay vì session
    public function order(Request $request)
{
    $selectedFoods = $request->input('food', []);

    if (empty($selectedFoods)) {
        return redirect()->route('food.index')->with('success', 'Vui lòng chọn ít nhất một món ăn.');
    }

    $user = Auth::user(); // Lấy user đang đăng nhập
    $totalPrice = 0;

    // Tạo đơn hàng với seat_id
    $order = Order::create([
        'user_id' => $user->id,
        'total_price' => 0, // Cập nhật sau
        'status' => 'pending',
    ]);

    // Thêm món ăn vào đơn hàng
    foreach ($selectedFoods as $foodId => $quantity) {
        $food = Food::find($foodId);
        if ($food) {
            $order->foods()->attach($food->id, [
                'quantity' => (int) $quantity,
                'price' => $food->price,
            ]);
            $totalPrice += $food->price * (int) $quantity;
        }
    }

    // Cập nhật tổng giá trị đơn hàng
    $order->update(['total_price' => $totalPrice]);

    return redirect()->route('food.index', ['order' => $order->id])->with('success', 'Đơn hàng đã được tạo thành công!');
}

public function indexs()
{
    $foodItems = Food::all(); // Lấy danh sách món ăn từ database
    return view('customer.food.index', compact('foodItems'));
}

// Xử lý đặt món ăn cho khách hàng
public function orderOfcustomer(Request $request)
{
    $selectedFoods = $request->input('food', []);
    $quantities = $request->input('quantity', []);
    $prices = $request->input('price', []);

    if (empty($selectedFoods)) {
        return redirect()->route('customer.food.index')->with('success', 'Vui lòng chọn ít nhất một món ăn.');
    }

    $user = Auth::user();
    $totalPrice = 0;

    // Tạo đơn hàng mới
    $order = Order::create([
        'user_id' => $user->id,
        'total_price' => 0, // Sẽ cập nhật sau
        'status' => 'pending',
    ]);

    $foodData = [];

    // Duyệt qua danh sách món ăn được chọn
    foreach ($selectedFoods as $foodId) {
        $quantity = isset($quantities[$foodId]) ? (int) $quantities[$foodId] : 1;
        $price = isset($prices[$foodId]) ? (float) $prices[$foodId] : 0;

        if ($quantity > 0 && $price > 0) {
            $foodData[$foodId] = [
                'quantity' => $quantity,
                'price' => $price,
            ];
            $totalPrice += $price * $quantity;
        }
    }

    // Nếu có món ăn hợp lệ thì lưu vào bảng food_order
    if (!empty($foodData)) {
        $order->foods()->attach($foodData);
        $order->total_price = $totalPrice;
        $order->save();
    } else {
        $order->delete(); // Xóa order nếu không có món hợp lệ
    }

    return redirect()->route('customer.food.index')->with('success', 'Đơn hàng của bạn đã được tạo thành công!');
}


}
