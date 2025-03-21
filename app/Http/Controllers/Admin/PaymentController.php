<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Flight;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {
    $data = $request->all();
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://127.0.0.1:8000/";
    $vnp_TmnCode = "QH1BY7UZ";//Mã website tại VNPAY 
    $vnp_HashSecret = "7VVAU55CR5UNJD9JB0CM08TPHBYEOAEV"; //Chuỗi bí mật
    
    $vnp_TxnRef = rand(0,99999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = 'Thanh toán đơn hàng';
    $vnp_OrderType = 'billpayment';
    $vnp_Amount = $data['total'] * 100;
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //Add Params of 2.0.1 Version
    //$vnp_ExpireDate = $_POST['txtexpire'];
    //Billing
    
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef
    );
    
    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    }
    
    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    
    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = ['code' => '00', 'message' => 'success'];

    if ($returnData['code'] === '00') {
        // Lấy thông tin vé từ database
        $ticket = Ticket::where('id', $request->ticket_id)->first();

        if ($ticket) {
            $user = User::find($ticket->user_id);
            $flight = Flight::find($ticket->flight_id);

            if ($user && $flight) {
                $booking = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'flight' => $flight->flight_number,
                    'seat' => $ticket->seat_number,
                    'price' => $request->amount
                ];

                // Kiểm tra config mail trước khi gửi
                $mailHost = config('mail.mailers.smtp.host');
                $mailFrom = config('mail.from.address');

                if ($mailHost && $mailFrom) {
                    Mail::to($booking['email'])->send(new BookingConfirmationMail($booking));
                } else {
                    Log::error('Mail configuration is missing. Check mail.php config.');
                }
            }
        }
    }

    return response()->json($returnData);
    }
}
