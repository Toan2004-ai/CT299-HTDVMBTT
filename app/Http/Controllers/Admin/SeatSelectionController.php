<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Flight;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SeatSelectionController extends Controller
{
    public function show($flight_id)
    {
        $flight = Flight::findOrFail($flight_id);
        $seats = Seat::where('flight_id', $flight_id)->get();

        return view('admin.tickets.seat_selection', compact('flight', 'seats'));
    }

    public function book(Request $request, $flight_id)
{
    $selectedSeats = $request->input('seats', []);

    if (empty($selectedSeats)) {
        return redirect()->route('tickets.seat_selection', ['flight_id' => $flight_id])
                         ->with('success', 'Bạn hãy chọn chỗ ngồi trước khi thực hiện bước kế tiếp!');
    }

    foreach ($selectedSeats as $seatNumber) {
        Seat::updateOrCreate(
            ['flight_id' => $flight_id, 'seat_number' => $seatNumber],
            ['status' => 'booked']
        );
    }

    return redirect()->route('tickets.seat_selection', ['flight_id' => $flight_id])
                     ->with('success', 'Bạn đã đặt chỗ thành công!');
}
public function bookSeat(Request $request, $flight_id)
{
    $seats = $request->input('seats'); // Danh sách ghế khách hàng chọn
    foreach ($seats as $seatNumber) {
        Seat::where('flight_id', $flight_id)
            ->where('seat_number', $seatNumber)
            ->update([
                'status' => 'booked',
                'user_id' => auth()->id() // Lưu ID của khách hàng đã đặt
            ]);
    }

    return redirect()->route('tickets.confirmation')->with('success', 'Bạn đã đặt ghế thành công!');
}


public function showForCustomer($flight_id)
{
    $flight = Flight::findOrFail($flight_id);
    $seats = Seat::where('flight_id', $flight_id)->get();

    return view('customer.tickets.seat_selection', compact('flight', 'seats'));
}

// Xử lý đặt ghế cho khách hàng
public function bookForCustomer(Request $request, $flight_id)
{
    $selectedSeats = $request->input('seats', []);

    if (empty($selectedSeats)) {
        return redirect()->route('customer.tickets.seat_selection', ['flight_id' => $flight_id])
            ->with('success', 'Bạn hãy chọn chỗ ngồi trước khi tiếp tục!');
    }

    foreach ($selectedSeats as $seatNumber) {
        Seat::updateOrCreate(
            ['flight_id' => $flight_id, 'seat_number' => $seatNumber],
            ['status' => 'booked', 'user_id' => Auth::id()]
        );
    }

    return redirect()->route('customer.tickets.seat_selection', ['flight_id' => $flight_id])->with('success', 'Bạn đã đặt chỗ thành công!');
}

}
