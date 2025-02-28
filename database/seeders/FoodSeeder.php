<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    public function run()
    {
        Food::insert( [
            ['name' => 'Popcorn (Small)', 'price' => 150, 'image' => '/img/popcorn1.png'],
            ['name' => 'Popcorn (Large)', 'price' => 200, 'image' => '/img/popcorn2.png'],
            ['name' => 'Coke', 'price' => 60, 'image' => '/img/cocola1.png'],
            ['name' => 'Diet Coke', 'price' => 80, 'image' => '/img/cocola2.png'],
            ['name' => 'Chicken Burger', 'price' => 180, 'image' => '/img/burger.png'],
            ['name' => 'Veg Pizza', 'price' => 200, 'image' => '/img/pizza.png'],
            ['name' => 'Pepsi (Small)', 'price' => 60, 'image' => '/img/pepsi.png'],
            ['name' => 'Pepsi', 'price' => 100, 'image' => '/img/pepsi2.png'],
            ['name' => 'Veg Sandwich', 'price' => 120, 'image' => '/img/sandwich.png'],
            ['name' => 'Chicken Sub', 'price' => 180, 'image' => '/img/sub.png'],
            ['name' => 'Sprite', 'price' => 80, 'image' => '/img/sprite.png'],
            ['name' => 'Donut', 'price' => 120, 'image' => '/img/donut.png'],
        ]);
    }
}
