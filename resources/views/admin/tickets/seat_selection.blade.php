@extends('layouts.master')

@section('content')
<main class="booking-part1">
    <h2 class="booking-title">Chọn chỗ ngồi</h2>
    <h3>Mã chuyến bay:{{ $flight->id }}<h3>

    <!-- Hiển thị thông báo -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Hướng dẫn chọn ghế -->
    <div class="legend">
        <i class='fas fa-couch seat red'></i> - Ghế đã được chọn&nbsp;&nbsp;&nbsp;
        <i class='fas fa-couch seat'></i> - Ghế chưa đặt&nbsp;&nbsp;&nbsp;
        <i class='fas fa-couch seat green'></i> - Ghế bạn chọn
    </div>

    <div class="legend">
        Giá vé 1 ghế thường = 200$ <br>  Giá vé 1 ghế thương gia = 600$
    </div>

    <!-- Hiển thị sơ đồ ghế -->
    <div class="display-seats">
        <form method="POST" action="{{ route('tickets.booking', ['flight_id' => $flight->id]) }}">
            @csrf
            <table class="all-the-seats">
                <tr class='rowno'>
                    <td></td>
                    @for($j = 1; $j <= 6; $j++) <!-- Hạng thương gia 6 chỗ -->
                        <td>{{ $j }}</td>
                    @endfor
                    <td></td> <!-- Hành lang -->
                    @for($j = 7; $j <= 20; $j++) <!-- Hạng phổ thông 4 chỗ -->
                        <td>{{ $j }}</td>
                    @endfor
                </tr>

                @php $rowLabel = 'A'; @endphp
                @for($i = 1; $i <= 6; $i++)
                    <tr>
                        <td class='column'>{{ $rowLabel }}</td>
                        @for($j = 1; $j <= 6; $j++) <!-- Hạng thương gia -->
                            @php
                                $seatNumber = $rowLabel . $j;
                                $seat = collect($seats)->where('seat_number', $seatNumber)->first();
                                $isBooked = $seat && $seat->status == 'booked';
                            @endphp
                            <td class="premium-seats">
                                <input type="checkbox" name="seats[]" value="{{ $seatNumber }}" id="seat-{{ $seatNumber }}" hidden {{ $isBooked ? 'disabled' : '' }}>
                                <i class="fas fa-couch seat {{ $isBooked ? 'red' : '' }}" onclick="selectSeat('{{ $seatNumber }}')" id="icon-{{ $seatNumber }}"></i>
                            </td>
                        @endfor
                        <td></td> <!-- Hành lang -->
                        @for($j = 7; $j <= 20; $j++) <!-- Hạng phổ thông -->
                            @php
                                $seatNumber = $rowLabel . $j;
                                $seat = collect($seats)->where('seat_number', $seatNumber)->first();
                                $isBooked = $seat && $seat->status == 'booked';
                            @endphp
                            <td class="economy-seats">
                                <input type="checkbox" name="seats[]" value="{{ $seatNumber }}" id="seat-{{ $seatNumber }}" hidden {{ $isBooked ? 'disabled' : '' }}>
                                <i class="fas fa-couch seat {{ $isBooked ? 'red' : '' }}" onclick="selectSeat('{{ $seatNumber }}')" id="icon-{{ $seatNumber }}"></i>
                            </td>
                        @endfor
                    </tr>
                    @php $rowLabel++; @endphp
                @endfor
            </table>

            <input type="submit" name="submit" value="Tiếp tục" class="continue-button">
        </form>
    </div>
</main>
    <style>
        /* Tổng thể */
        .booking-part1 {
            text-align: center;
            background-color: #d3cdcd;
            padding: 20px;
            border-radius: 10px;
        }

        /* Tiêu đề */
        .booking-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Hướng dẫn chọn ghế */
        .legend {
            font-size: 16px;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .legend i {
            font-size: 24px;
            margin-right: 8px;
        }

        /* Sơ đồ ghế */
        .display-seats {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        /* Bảng hiển thị ghế */
        .all-the-seats {
            border-collapse: separate;
            border-spacing: 8px;
            background: #e6e3e3;
            padding: 20px;
            border-radius: 10px;
        }

        /* Căn chỉnh hàng ghế */
        .rowno td,
        .column {
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            padding: 5px;
        }

        /* Biểu tượng ghế */
        .seat {
            font-size: 30px;
            cursor: pointer;
            color: #4d4d4d; /* Mặc định ghế trống màu xám */
            transition: transform 0.2s ease-in-out;
        }

        .seat:hover {
            transform: scale(1.2);
        }

        /* Ghế đã đặt (không thể chọn) */
        .seat.red {
            color: red;
            pointer-events: none;
        }

        /* Ghế đã chọn */
        .seat.green {
            color: green;
        }

        /* Nút tiếp tục */
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

        /* Cấu trúc hạng ghế */
        .premium-seats {
            background-color: #b0e0e6; /* Hạng thương gia */
        }

        .economy-seats {
            background-color: #e6e3e3; /* Hạng phổ thông */
        }
    </style>
    <script>
        function selectSeat(seatNumber) {
            let seatCheckbox = document.getElementById("seat-" + seatNumber);
            let seatIcon = document.getElementById("icon-" + seatNumber);
    
            if (!seatCheckbox.disabled) {
                seatCheckbox.checked = !seatCheckbox.checked;
                seatIcon.classList.toggle("green", seatCheckbox.checked);
            }
        }
    </script>
@endsection
