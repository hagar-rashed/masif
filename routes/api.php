<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\Dashboard\ServiceController;
use App\Http\Controllers\Api\Site\ServiceController as SiteServiceController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\Dashboard\VallageController;
use App\Http\Controllers\Api\Dashboard\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//////////////////////amira///////////////////////////////////////////
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\RestaurantBookingController;
use App\Http\Controllers\Api\MenuItemController;
///////////////////////////////////////////////////////////////////////

use App\Http\Controllers\Api\CafeController;
use App\Http\Controllers\Api\CafeBookingController;
use App\Http\Controllers\Api\CafeItemController;

//////////////////////////////////////////////////////////////////////////
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::
        namespace('Api')->group(function () {

            // Home Routes
            Route::get('home', 'HomeController@index');
            Route::post('mail-list', 'HomeController@mailList');
            Route::get('search', 'HomeController@search');

            // Books Routes
            Route::get('books', 'BookController@index');
            Route::get('books/{id}', 'BookController@show');
            // Route::post('download-book/{id}', 'BookController@downloadBook');
        
            // Contact Routes
            Route::post('send-contact', 'ContactController@sendContact');

            // Article & Research Routes
            Route::get('articles', 'ArticleController@index');
            Route::get('show-article/{id}', 'ArticleController@showArticle');
            Route::get('show-research/{id}', 'ArticleController@showResearch');

            // Videos Routes
            Route::get('videos', 'VideoController@index');
        });


Route::post('/login', [AuthController::class, 'login_user']);
Route::post('/register', [AuthController::class, 'register_user']);


Route::get('auth/{facebook}', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('auth/{facebook}/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::get('auth/{twitter}', [SocialAuthController::class, 'redirectToTwitter']);
Route::get('auth/{twitter}/callback', [SocialAuthController::class, 'handleTwitterCallback']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout_user']);
    Route::get('/notifications', [OfferController::class, 'getNotifications']);
    Route::post('/notifications/read', [OfferController::class, 'markAsRead']);

    //-----------------------Booking-----------------
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{id}', [BookingController::class, 'show_one']);
    Route::post('/bookings/create', [BookingController::class, 'store']);
    Route::patch('/bookings/update/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/delete/{id}', [BookingController::class, 'destroy']);

    //-----------------------Offers-----------------
    Route::get('/offers', [OfferController::class, 'showOffers']);
});

// services Route dashboard
Route::get('services', [ServiceController::class, 'index']);
Route::post('services', [ServiceController::class, 'store']);
Route::get('services/{id}', [ServiceController::class, 'show']);
Route::put('services/{id}', [ServiceController::class, 'update']);
Route::delete('services/{id}', [ServiceController::class, 'destroy']);


// services Route site
Route::get('site/services/{village_id}', [SiteServiceController::class, 'getByVillage']);
Route::get('site/services/{id}', [SiteServiceController::class, 'show']);
Route::get('site/services', [SiteServiceController::class, 'index']);

// services villages site
Route::get('villages', [VallageController::class, 'index']);
Route::post('villages', [VallageController::class, 'store']);
Route::get('villages/{id}', [VallageController::class, 'show']);
Route::put('villages/{id}', [VallageController::class, 'update']);

Route::delete('villages/{id}', [VallageController::class, 'destroy']);


Route::get('reviews', [ReviewController::class,'index']);
Route::post('reviews', [ReviewController::class,'store']);


//Restaurants update (amira)//////////////////////////////////////////////////////////////////////////
Route::get('restaurants', [RestaurantController::class, 'index']);
Route::get('restaurants/{id}', [RestaurantController::class, 'show']);
Route::post('restaurants', [RestaurantController::class, 'store']);
Route::post('restaurants/{id}', [RestaurantController::class, 'update']);
Route::delete('restaurants/{id}', [RestaurantController::class, 'destroy']);
Route::post('restaurants/{restaurantId}/bookings', [RestaurantBookingController::class, 'store']);

Route::get('restaurants/{id}/generate-qr', [RestaurantController::class, 'generateQrCodeForRestaurant']);
Route::get('restaurants/{id}/menu-items-image', [RestaurantController::class, 'getMenuItemsWithImage']);

Route::post('menu-items', [MenuItemController::class, 'store']);
Route::post('menu-items/{id}', [MenuItemController::class, 'update']);
Route::delete('menu-items/{id}', [MenuItemController::class, 'destroy']);
Route::post('cart/add', [MenuItemController::class, 'addToCart']);

//////////////////////////new////////////////////////////////////////////////////////////////////////////////////////

Route::get('cafes', [CafeController::class, 'index']);
Route::get('cafes/{id}', [CafeController::class, 'show']);
Route::post('cafes', [CafeController::class, 'store']);
Route::put('cafes/{id}', [CafeController::class, 'update']);
Route::delete('cafes/{id}', [CafeController::class, 'destroy']);   
Route::post('cafes/{cafeId}/bookings', [CafeBookingController::class, 'store']); 


Route::get('cafes/{id}/generate-qr', [CafeController::class, 'generateQrCodeForCafe']);
Route::get('cafes/{id}/cafe-items-image', [CafeController::class, 'getCafeItemsWithImage']);

Route::post('cafe-items', [CafeItemController::class, 'store']);
Route::put('cafe-items/{id}', [CafeItemController::class, 'update']);
Route::delete('cafe-items/{id}', [CafeItemController::class, 'destroy']);
