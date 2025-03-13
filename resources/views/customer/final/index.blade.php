@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="text-center">Xác nhận thanh toán</h2>

    <div class="card mt-4">
        <div class="card-body">
            <h4>Mã chuyến bay: {{ $flight->id ?? 'Không xác định' }}</h4>
            <p><strong>Đi từ:</strong> {{ $flight->origin->name ?? 'Không xác định' }}</p>
            <p><strong>Đến:</strong> {{ $flight->destination->name ?? 'Không xác định' }}</p>
            <p><strong>Hành khách:</strong> {{ $user->name }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h4>Chỗ ngồi</h4>
            <ul>
                @foreach($seats as $seat)
                    <li>Ghế: {{ $seat->seat_number }} - 
                        <strong>{{ $seat->seat_type == 'business' ? 'Thương gia (600$)' : 'Thường (200$)' }}</strong>
                    </li>
                @endforeach
            </ul>            
            <p><strong>Tổng tiền ghế:</strong> {{ number_format($seat_total) }} $</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h4>Dịch vụ ăn uống</h4>
            <ul>
                @forelse($food_orders as $food)
                    <li>Tên món: {{ $food->name }} - Số lượng: {{ $food->quantity }} - Giá: {{ $food->price * $food->quantity}} $</li>
                @empty
                    <li>Không có món ăn nào được chọn.</li>
                @endforelse
            </ul>
            <p><strong>Tổng tiền món ăn:</strong> {{ number_format($food_total) }} $</p>
        </div>
        
    </div>

    <div class="card mt-4">
        <div class="card-body text-center">
            <h4>Tổng tiền phải thanh toán: <span class="text-danger">{{ number_format($total_price) }} VND</span></h4>
        </div>
    </div>
</div>
@endsection
