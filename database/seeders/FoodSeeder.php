<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    public function run()
    {
        Food::insert( [
            ['name' => 'Popcorn (Small)', 'price' => 150000, 'image' => '/img/popcorn1.png'],
            ['name' => 'Popcorn (Large)', 'price' => 200000, 'image' => '/img/popcorn2.png'],
            ['name' => 'Coke', 'price' => 60000, 'image' => '/img/cocola1.png'],
            ['name' => 'Diet Coke', 'price' => 80000, 'image' => '/img/cocola2.png'],
            ['name' => 'Chicken Burger', 'price' => 180000, 'image' => '/img/burger.png'],
            ['name' => 'Veg Pizza', 'price' => 200000, 'image' => '/img/pizza.png'],
            ['name' => 'Pepsi (Small)', 'price' => 60000, 'image' => '/img/pepsi.png'],
            ['name' => 'Pepsi', 'price' => 100000, 'image' => '/img/pepsi2.png'],
            ['name' => 'Veg Sandwich', 'price' => 120000, 'image' => '/img/sandwich.png'],
            ['name' => 'Chicken Sub', 'price' => 180000, 'image' => '/img/sub.png'],
            ['name' => 'Sprite', 'price' => 80000, 'image' => '/img/sprite.png'],
            ['name' => 'Donut', 'price' => 120000, 'image' => '/img/donut.png'],
        ]);
    }
}
