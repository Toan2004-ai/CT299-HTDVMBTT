<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đặt vé thành công</title>
</head>
<body>
    <h2>Chào {{ $user }},</h2>
    <p>Cảm ơn bạn đã đặt vé với chúng tôi. Dưới đây là thông tin chi tiết về chuyến bay của bạn:</p>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Chuyến bay</th>
            <td>{{ $flight }}</td>
        </tr>
        <tr>
            <th>Số ghế</th>
            <td>{{ $seat }}</td>
        </tr>
        <tr>
            <th>Giá vé</th>
            <td>{{ $price }}</td>
        </tr>
    </table>
    
    <p>Chúc bạn có một chuyến bay an toàn!</p>
    <p>Trân trọng,</p>
    <p><strong>Hệ thống đặt vé máy bay</strong></p>
</body>
</html>
