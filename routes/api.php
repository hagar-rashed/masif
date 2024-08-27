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

//////////////////////      Amira Gaber     ////////////////////////////////////////////////////////////////
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\RestaurantBookingController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\RestaurantCategoryController;
use App\Http\Controllers\Api\CafeController;
use App\Http\Controllers\Api\CafeCategoryController;
use App\Http\Controllers\Api\CafeBookingController;
use App\Http\Controllers\Api\CafeItemController;
use App\Http\Controllers\Api\CinemaController;
use App\Http\Controllers\Api\MovieController;
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


////////////////////////////////  Amira Gaber   //////////////////////////////////////////////////////////////////////////
Route::prefix('restaurants')->group(function(){
    Route::get('/', [RestaurantController::class, 'index']);
    Route::get('{id}', [RestaurantController::class, 'show']);
    Route::post('/', [RestaurantController::class, 'store']);
    Route::post('{id}', [RestaurantController::class, 'update']);
    Route::delete('{id}', [RestaurantController::class, 'destroy']);   
    Route::get('{id}/generate-qr', [RestaurantController::class, 'generateQrCodeForRestaurant']);
    Route::post('{restaurantId}/bookings', [RestaurantBookingController::class, 'store']);
    Route::get('{id}/categories', [RestaurantCategoryController::class, 'index']);
    Route::post('{id}/categories', [RestaurantCategoryController::class, 'store']);    
    Route::post('{restaurant_id}/categories/{category_id}', [RestaurantCategoryController::class, 'update']);

});
Route::get('restaurant-categories/{id}', [RestaurantCategoryController::class, 'show']);
Route::delete('restaurant-categories/{id}', [RestaurantCategoryController::class, 'destroy']);

Route::prefix('menu-items')->group(function(){    
    Route::get('category/{category_id}', [MenuItemController::class, 'index']);
    Route::get('{id}', [MenuItemController::class, 'show']);   
    Route::post('category/{category_id}', [MenuItemController::class, 'store']);
    Route::post('category/{category_id}/{id}', [MenuItemController::class, 'update']);  
    Route::delete('{id}', [MenuItemController::class, 'destroy']);
    Route::post('cart/add', [MenuItemController::class, 'addToCart']);
});

Route::prefix('cafes')->group(function(){
    Route::get('/', [CafeController::class, 'index']);
    Route::get('{id}', [CafeController::class, 'show']);
    Route::post('/', [CafeController::class, 'store']);
    Route::post('{id}', [CafeController::class, 'update']);
    Route::delete('{id}', [CafeController::class, 'destroy']);     
    Route::get('{id}/generate-qr', [CafeController::class, 'generateQrCodeForCafe']);
    Route::post('{cafeId}/bookings', [CafeBookingController::class, 'store']); 

    Route::get('{id}/categories', [CafeCategoryController::class, 'index']);
    Route::post('{cafe_id}/categories', [CafeCategoryController::class, 'store']);
    Route::post('{cafe_id}/categories/{category_id}', [CafeCategoryController::class, 'update']);
});

Route::get('cafe-categories/{id}', [CafeCategoryController::class, 'show']);
Route::delete('cafe-categories/{id}', [CafeCategoryController::class, 'destroy']);

Route::prefix('cafe-items')->group(function(){
    Route::get('category/{category_id}', [CafeItemController::class, 'index']);
    Route::get('{id}', [CafeItemController::class, 'show']);
    Route::post('category/{category_id}', [CafeItemController::class, 'store']);    
    Route::post('category/{category_id}/{id}', [CafeItemController::class, 'update']);
    Route::delete('{id}', [CafeItemController::class, 'destroy']);
    Route::post('cart/add', [CafeItemController::class, 'addToCart']);
});

Route::prefix('cinemas')->group(function(){
    Route::get('/', [CinemaController::class, 'index']);
    Route::get('{id}', [CinemaController::class, 'show']);
    Route::post('/', [CinemaController::class, 'store']);
    Route::post('{id}', [CinemaController::class, 'update']);
    Route::delete('{id}', [CinemaController::class, 'destroy']);
    Route::get('{id}/movies', [CinemaController::class, 'showMovies']);
});

Route::prefix('movies')->group(function(){
    Route::get('/', [MovieController::class, 'index']);
    Route::get('{id}', [MovieController::class, 'show']);
    Route::post('/', [MovieController::class, 'store']);    
    Route::post('{id}', [MovieController::class, 'update']);
    Route::delete('{id}', [MovieController::class, 'destroy']);
});



