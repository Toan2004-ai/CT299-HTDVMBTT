<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\{
    HomeController,
    AirlineController,
    AirportController,
    CustomerController,
    PlaneController,
    FlightController,
    ProfileController,
    TicketController,
    SeatSelectionController,
    FoodController,
    FinalController
};

use App\Http\Controllers\SandboxController;
use App\Http\Controllers\SidebarControler;

Auth::routes();

Route::group(["prefix" => 'dashboard'], function () {
    Route::group(['middleware' => 'auth'], function () {
        /* ================== USER ROUTES ================== */

        //profile
        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');


        //tickets
        Route::get('tickets/show-flights', [TicketController::class, 'showFlights'])->name('tickets.flights');
        Route::get('tickets/user-tickets', [TicketController::class, 'userTickets'])->name('tickets.userTickets');
        Route::post('tickets/book', [TicketController::class, 'book'])->name('tickets.book');
        Route::post('tickets/cancel-flight', [TicketController::class, 'cancel'])->name('tickets.cancel');

        //customers
        Route::get('/customer/tickets/seat_selection/{flight_id}', [SeatSelectionController::class, 'showForCustomer'])->name('customer.tickets.seat_selection');
        Route::post('/customer/tickets/seat_selection/{flight_id}/booking', [SeatSelectionController::class, 'bookForCustomer'])->name('customer.tickets.booking')->middleware('auth');

        //foods
        Route::get('/customer/food', [FoodController::class, 'indexs'])->name('customer.food.index');
        Route::post('/customer/food', [FoodController::class, 'store'])->name('customer.food.store');
        Route::post('/customer/food/order', [FoodController::class, 'orderOfcustomer'])->name('customer.food.order');

        //final
        Route::get('/customer/final', [FinalController::class, 'index'])->name('customer.final.index');

        /* ================== ADMIN ROUTES ================== */
        Route::group(['middleware' => 'admin'], function () {
            Route::get('/', [HomeController::class, 'root'])->name('root');

            //get count of tickets
            Route::get('/ticket-status-count', [SidebarControler::class, 'ticketStatusCount'])->name('ticketStatusCount');

            //airlines
            Route::resource("airlines", AirlineController::class);

            //planes
            Route::resource("planes", PlaneController::class)->except('show');

            //airports
            Route::resource("airports", AirportController::class)->except('show');

            //flights
            Route::get("flights/get-planes-by-airline", [FlightController::class, 'getPlanesByAirline'])->name('flights.getPlanesByAirline');
            Route::resource("flights", FlightController::class)->except('show');

            //tickets
            Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
            Route::post('tickets/change-status/{ticket}', [TicketController::class, 'changeStatus'])->name('tickets.changeStatus');
            
            //seats
            Route::get('tickets/seat_selection/{flight_id}', [SeatSelectionController::class, 'show'])->name('tickets.seat_selection');
            Route::post('tickets/seat_selection/{flight_id}/booking', [SeatSelectionController::class, 'book'])->name('tickets.booking');

            //customers
            Route::get("customers", [CustomerController::class, "index"])->name('customers.index');
            Route::get("customers/{user}", [CustomerController::class, "show"])->name('customers.show');
        });
    });
});

Route::view('/', 'index');

//Language Translation
Route::get('/index/{locale}', [HomeController::class, 'lang/vn']);

Route::post('/store-temp-file', [HomeController::class, 'storeTempFile'])->name('storeTempFile');
Route::post('/delete-temp-file', [HomeController::class, 'deleteTempFile'])->name('deleteTempFile');

Route::get('/get-random-customer', [SandboxController::class, 'randomCustomer'])->name('randomCustomer');

//render files inside views/template folder
Route::get('{any}', [HomeController::class, 'index'])->name('index');
