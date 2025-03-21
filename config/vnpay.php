<?php

return [
    'vnp_TmnCode' => env('VNP_TMNCODE', 'YOUR_TMN_CODE'),
    'vnp_HashSecret' => env('VNP_HASHSECRET', 'YOUR_HASH_SECRET'),
    'vnp_Url' => env('VNP_URL', 'http://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'vnp_Returnurl' => env('VNP_RETURNURL', 'http://nhom6.com:8000/return-vnpay'),
];