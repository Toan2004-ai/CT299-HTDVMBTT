<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model {
    use HasFactory;

    protected $table = 'foods'; // Thêm dòng này để Laravel biết bảng chính xác
    protected $fillable = ['name', 'price', 'image'];


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'food_order')->withPivot('quantity', 'price');
    }
}

