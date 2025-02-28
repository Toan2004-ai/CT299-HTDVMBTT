@extends('layouts.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<main class="booking-part1">
    <h2 class="booking-title">Food</h2>
    <form action="{{ route('customer.food.order') }}" method="POST">
        @csrf
        <div class="row justify-content-center">
            @foreach ($foodItems as $food)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card food-card text-center">
                        <img src="{{ asset($food['image']) }}" alt="image" class="food-img" height="150" width="150">
                        <h5 class="food-title">{{ $food['name'] }}</h5>
                        <p class="food-price">₹{{ $food['price'] }}</p>
                        
                        <!-- Thêm checkbox để chọn món -->
                        <input type="checkbox" name="food[{{ $food['id'] }}]" value="{{ $food['id'] }}" class="food-checkbox" id="food-{{ $food['id'] }}">
                        <label for="food-{{ $food['id'] }}" class="add-btn">Add</label>
                        
                        <!-- Thêm input số lượng (chỉ nhập khi checkbox được chọn) -->
                        <input type="number" name="quantity[{{ $food['id'] }}]" value="1" min="1" class="food-quantity" disabled>
                        
                        <!-- Giữ giá món ăn -->
                        <input type="hidden" name="price[{{ $food['id'] }}]" value="{{ $food['price'] }}">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="button-group">
           <input type="submit" class="btn btn-primary btn-lg continue-button" value="Hoàn tất">
        </div>
    </form>
    <form method="GET" class="button-group" action="{{ route('customer.final.index') }}">
        <input type="submit" name="submit" value=">>" class="complete-button">
    </form>
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let checkboxes = document.querySelectorAll(".food-checkbox");
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                let quantityInput = this.closest(".food-card").querySelector(".food-quantity");
                quantityInput.disabled = !this.checked;
            });
        });
    });
    </script>
    
</main>
@endsection
<style>
.container {
    max-width: 900px; /* Giới hạn chiều rộng */
    margin: auto; /* Căn giữa trang */
}

.food-card {
    display: flex; /* Hiển thị ngang thay vì dọc */
    align-items: center; /* Căn giữa theo chiều dọc */
    justify-content: space-between;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    margin-bottom: 15px; /* Tạo khoảng cách giữa các món */
    max-width: 600px; /* Giữ layout gọn gàng */
}

.food-card:hover {
    transform: scale(1.02);
}

.food-img {
    width: 80px;
    height: 80px;
    object-fit: contain;
    margin-right: 15px;
}

.food-info {
    flex: 1;
}

.food-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
}

.food-price {
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
}

/* Nút Add */
.food-checkbox {
    display: none;
}

.add-btn {
    display: inline-block;
    padding: 8px 15px;
    background: white;
    border: 1px solid black;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s;
}

.food-checkbox:checked + .add-btn {
    background: black;
    color: white;
}

.continue-button {
            background-color: black;
            color: white;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        .continue-button:hover {
            background-color: #333;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .complete-button {
            background-color: black;
            color: white;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
</style>
