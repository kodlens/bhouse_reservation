<?php

use App\Models\RoomType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
]);

Route::middleware('guest')->get('/gate', function () {
    //this route will check and redirect user
});


Route::get('/sample',[App\Http\Controllers\SampleController::class,'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::resource('/register', App\Http\Controllers\RegisterPageController::class);
Route::post('/register-landowner', [App\Http\Controllers\RegisterPageController::class, 'saveLandOwner']);
Route::post('/register-boarder', [App\Http\Controllers\RegisterPageController::class, 'saveBoarder']);



//ADDRESS
Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);
//get, post, put, delete



//ADMINSITRATOR
Route::resource('/dashboard', App\Http\Controllers\Administrator\AdminDashboardController::class);

Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getUsers']);
Route::post('/user-reset-password/{id}', [App\Http\Controllers\Administrator\UserController::class, 'resetPassword']);

Route::post('/user-deactivate/{id}', [App\Http\Controllers\Administrator\UserController::class, 'deactivate']);
Route::post('/user-activate/{id}', [App\Http\Controllers\Administrator\UserController::class, 'activate']);



Route::resource('/request-accounts', App\Http\Controllers\Administrator\RequestAccountController::class);
Route::get('/get-request-accounts', [App\Http\Controllers\Administrator\RequestAccountController::class, 'getRequestAccount']);
Route::post('/request-account-approved/{id}', [App\Http\Controllers\Administrator\RequestAccountController::class, 'approveAccount']);
Route::post('/request-account-disapproved/{id}', [App\Http\Controllers\Administrator\RequestAccountController::class, 'disapproveAccount']);


//ROUTE FOR REQUEST BHOUSE // KANANG MAG PA APPROVE SA BHOUSE E DISPLAY
// ANG BUSINESS PERMIT
Route::resource('/bh-request', App\Http\Controllers\Administrator\BHRequestController::class);
Route::get('/get-bh-requests', [App\Http\Controllers\Administrator\BHRequestController::class, 'getBHRequests']);
Route::post('/bh-request-approved/{id}', [App\Http\Controllers\Administrator\BHRequestController::class, 'approveBh']);
Route::post('bh-request-deactivate/{id}', [App\Http\Controllers\Administrator\BHRequestController::class, 'deactivateBh']);


//---------------------------//
//-----------BHLIST----------------//
Route::resource('/bh-lists', App\Http\Controllers\Administrator\BhListController::class);
Route::get('/get-bh-lists', [App\Http\Controllers\Administrator\BhListController::class, 'getBhLists']);


Route::resource('/bh-rules', App\Http\Controllers\Administrator\BHRuleController::class);
Route::get('/get-bh-rules', [App\Http\Controllers\Administrator\BHRuleController::class, 'getBhRules']);


//---------------------------//
//---------------------------//


//load OPEN amenities
Route::get('/load-open-amenities', function(){
    return \App\Models\Amenity::orderBy('amenity', 'asc')->get();
});
//load OPEN rules
Route::get('/load-open-rules', function(){
    return \App\Models\Rule::orderBy('rule', 'asc')->get();
});

Route::get('/load-open-room-types', function(){
    return RoomType::orderBy('room_type', 'asc')->get();
});



Route::middleware(['auth'])->group(function() {

    //==============================//
    //==========LANDOWNER============//
    //===============================//

    Route::resource('/amenities', App\Http\Controllers\LandOwner\AmenityController::class);

    Route::resource('/landowner-dashboard', App\Http\Controllers\LandOwner\LandownerDashboardController::class);
    Route::get('/get-landowner-bhouses', [App\Http\Controllers\LandOwner\LandownerDashboardController::class, 'getLandOwnerBhouses']);

    //BOARDING HOUSE
    Route::resource('/boarding-house', App\Http\Controllers\LandOwner\LandownerBoardingHouseController::class);
    Route::post('/boarding-house-update/{id}', [App\Http\Controllers\LandOwner\LandownerBoardingHouseController::class, 'update']);
    Route::get('/get-boarding-houses', [App\Http\Controllers\LandOwner\LandownerBoardingHouseController::class, 'getBoardingHouses']); //get Boarding House of the landowner


    //BOARDING HOUSE - BEDSPACE
    Route::get('/boarding-house-bedspace/{room_id}', [App\Http\Controllers\LandOwner\LandownerBedspaceController::class, 'index']);
    Route::get('/get-boarding-house-bedspaces/{id}', [App\Http\Controllers\LandOwner\LandownerBedspaceController::class, 'getBedSpaces']);

    //BOARDING HOUSE ROOMS LAND OWNER
    Route::get('/boarding-house-rooms/{id}', [App\Http\Controllers\LandOwner\LandOwnerRoomController::class, 'index']);
    Route::post('/boarding-house-rooms/{id}', [App\Http\Controllers\LandOwner\LandOwnerRoomController::class, 'store']);
    Route::post('/boarding-house-rooms-update/{id}', [App\Http\Controllers\LandOwner\LandOwnerRoomController::class, 'update']);


    Route::get('/get-boarding-house-rooms/{id}', [App\Http\Controllers\LandOwner\LandOwnerRoomController::class, 'getRooms']);
    Route::delete('/boarding-house-room-delete/{id}', [App\Http\Controllers\LandOwner\LandOwnerRoomController::class, 'destroy']);

    Route::get('/get-boarding-house-room-edit/{id}', [App\Http\Controllers\LandOwner\LandOwnerRoomController::class, 'getBhouseRoomEdit']);

    Route::get('/boarder-reservation', [App\Http\Controllers\LandOwner\BoarderReservationController::class, 'index']);
    Route::get('/get-boarder-reservation', [App\Http\Controllers\LandOwner\BoarderReservationController::class, 'getBoarderReservation']);


});









//-------------LANDOWNER------------///
//----------------------------------///


Route::post('/boarding-house-bedspace/{bhouse_id}/{room_id}', [App\Http\Controllers\LandOwner\LandownerBedspaceController::class, 'store']);
//Route::get('/get-boarding-house-bedspaces-imgs/{id}', [App\Http\Controllers\LandOwner\LandownerBedspaceController::class, 'getBedspaceImgs']);
Route::put('/boarding-house-bedspace-update/{id}', [App\Http\Controllers\LandOwner\LandownerBedspaceController::class, 'update']);

Route::get('/get-bhouse-bedspaces/{id}', [App\Http\Controllers\LandOwner\LandownerBedspaceController::class, 'getBhBedspaces']);
Route::delete('/boarding-house-bedspace-delete/{id}', [App\Http\Controllers\LandOwner\LandownerBedspaceController::class, 'destroy']);

//bedspace images
Route::get('/boarding-house-bedspace/{bhid}/{roomid}/{bedspaceid}', [App\Http\Controllers\LandOwner\BedspaceImageController::class, 'index']);
Route::post('/boarding-house-bedspace-store/{bedspaceid}', [App\Http\Controllers\LandOwner\BedspaceImageController::class, 'store']);

Route::get('/get-bedspace-imgs/{bedspaceid}', [App\Http\Controllers\LandOwner\BedspaceImageController::class, 'getImages']);
Route::delete('/bedspace-imgs-delete/{bedspaceid}', [App\Http\Controllers\LandOwner\BedspaceImageController::class, 'destroy']);


//-------------------------///


// search boarding house controller
Route::get('/get-search-rentals', [App\Http\Controllers\SearchRentalController::class, 'getSearchBhouses']);


//CLIENT BOARDING HOUSES //
Route::get('/get-client-bhouses', [App\Http\Controllers\ClientBhouseController::class, 'getBhouses']);
Route::get('/client-bhouse-detail/{id}', [App\Http\Controllers\ClientBhouseController::class, 'showBhouseDetail']);
Route::get('/get-bhouse-detail/{id}', [App\Http\Controllers\ClientBhouseController::class, 'getBhouseDetail']);





//CLIENT BHROOM
Route::get('/client-bh-rooms/{id}', [App\Http\Controllers\ClientBhouseRoomController::class, 'index']);
Route::get('/get-client-bh-rooms/{id}', [App\Http\Controllers\ClientBhouseRoomController::class, 'getBhRoomsClient']);
Route::get('/get-client-bhroom-bedspaces/{id}', [App\Http\Controllers\ClientBhouseRoomController::class, 'getBedSpaces']);
Route::post('/client-bhroom-bedspace-reserve/{bedspace_id}', [App\Http\Controllers\ClientReserveBedSpaceController::class, 'reserveBedspace']);


//boarder, already have account and already login
Route::middleware(['auth'])->group(function() {

    Route::get('/rental-reserve/{id}', [App\Http\Controllers\Boarder\RentalReserveController::class, 'index']);
    Route::post('/rental-reserve-now', [App\Http\Controllers\Boarder\RentalReserveController::class, 'rentalReserveNow']);

    Route::resource('/my-reservations', App\Http\Controllers\Boarder\MyReservationController::class);
    Route::get('/get-my-reservations', [App\Http\Controllers\Boarder\MyReservationController::class, 'getMyReservations']);
    Route::post('/cancel-my-reservations/{id}', [App\Http\Controllers\Boarder\MyReservationController::class, 'cancelReservation']);
    Route::post('/upload-gcash-receipt/{id}', [App\Http\Controllers\Boarder\MyReservationController::class, 'uploadGcash']);





});



Route::get('/session', function(){
    return Session::all();
});
