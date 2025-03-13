<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'flight_number',
        'airline_id',
        'plane_id',
        'origin_id',
        'destination_id',
        'departure',
        'arrival',
        'departure_time', // Đảm bảo có cột này
        'arrival_time',   // Đảm bảo có cột này
        'seats',
        'remain_seats',
        'price',
        'status',
    ];
    
    
    protected $with = ['airline:id,name', "plane:id,code", 'origin:id,name', 'destination:id,name'];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function plane()
    {
        return $this->belongsTo(Plane::class, 'plane_id')->withDefault([
            'code' => 'N/A',
            "name" => "N/A"
        ]);
    }

    public function origin()
    {
        return $this->belongsTo(Airport::class, "origin_id");
    }

    public function destination()
    {
        return $this->belongsTo(Airport::class, "destination_id");
    }
}
