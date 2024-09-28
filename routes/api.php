<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\Dashboard\ServiceController;
use App\Http\Controllers\Api\Site\ServiceController as SiteServiceController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\Dashboard\VallageController;
use App\Http\Controllers\Api\Dashboard\ReviewController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\RestaurantBookingController;
use App\Http\Controllers\Api\CafeController;
use App\Http\Controllers\Api\CafeBookingController;
use App\Http\Controllers\Api\Dashboard\SupermarketController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\Dashboard\ProductController;
use App\Http\Controllers\Api\Dashboard\CartController;
use App\Http\Controllers\Api\CafeCategoryController;
use App\Http\Controllers\Api\CafeItemController;
use App\Http\Controllers\Api\CinemaController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\RestaurantCategoryController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Api\Site\TransportationController;
use App\Http\Controllers\Api\CompanyProfileController;
use App\Http\Controllers\Api\VisitorProfileController;
use App\Http\Controllers\Api\OwnerUnitController;
use App\Http\Controllers\Api\OfferTripController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\OtherController;
use App\Http\Controllers\Api\TourismController;
use App\Http\Controllers\Api\FavoritesController;
use App\Http\Controllers\Api\Site\VillageController;
use App\Http\Controllers\Api\TripBookingController;
use App\Http\Controllers\Api\MovieBookingController;
use App\Http\Controllers\Api\RoomBookingController;
use App\Http\Controllers\Api\MyQRCodeController;
use App\Http\Controllers\Api\ScreenController;
use App\Http\Controllers\Api\RoomOfferController;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

////////////////////////  chat amira gaber /////////////////////////////////////////////////////////////////
    Route::post('/chats', [ChatController::class, 'startChat']);
    Route::post('/chats/{chat_id}/messages', [ChatController::class, 'sendMessage']);
    Route::get('/chats/{chat_id}/messages', [ChatController::class, 'getMessages']);
    Route::get('/chats', [ChatController::class, 'getChats']);
    Route::post('/messages/{message_id}/read',  [ChatController::class, 'markAsRead']);
    Route::get('/notifications',  [ChatController::class, 'getNotifications']);
    Route::get('/search-participants', [ChatController::class, 'searchParticipants']);
     Route::get('/visits', [VisitController::class, 'index']);
    Route::get('/visits/{id}', [VisitController::class, 'show']);
    Route::post('/visits', [VisitController::class, 'store']);
    Route::post('/visits/{id}', [VisitController::class, 'update']);
    Route::delete('/visits/{id}', [VisitController::class, 'destroy']);

     Route::get('validate-qr/{visitId}', [VisitController::class, 'validateQrCode']);

    Route::get('/units', [OwnerUnitController::class, 'index']);
    Route::post('/units', [OwnerUnitController::class, 'store']);
    Route::get('/units/{id}', [OwnerUnitController::class, 'show']);
    Route::post('/units/{id}', [OwnerUnitController::class, 'update']);
    Route::delete('/units/{id}', [OwnerUnitController::class, 'destroy']);
    Route::get('/myunits', [OwnerUnitController::class, 'ownerUnits']);

      Route::get('/trips', [OfferTripController::class, 'index']);
    Route::get('/trips/{id}', [OfferTripController::class, 'show']);
    Route::post('/tourisms/{tourismId}/trips', [OfferTripController::class, 'store']);
    Route::post('/trips/{id}', [OfferTripController::class, 'update']);
    Route::delete('/trips/{id}', [OfferTripController::class, 'destroy']);
    Route::get('offer-trips/{userId}', [OfferTripController::class, 'getTripsByUser']);
    Route::get('my-trips', [OfferTripController::class, 'getAuthenticatedUserTrips']);
    Route::get('trip-notification', [NotificationController::class, 'getNotifications']);
    Route::post('trip-notification/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('trips/{trip_offer}/book', [TripBookingController::class, 'store']);

    Route::get('/trips-offers', [OfferTripController::class, 'getTripsWithOffers']);

    Route::get('others', [OtherController::class, 'index']);
    Route::post('others', [OtherController::class, 'store']);
    Route::get('others/{id}', [OtherController::class, 'show']);
    Route::post('others/{id}', [OtherController::class, 'update']);
    Route::delete('others/{id}', [OtherController::class, 'destroy']);

    Route::get('tourisms', [TourismController::class, 'index']);
    Route::post('tourisms', [TourismController::class, 'store']);
    Route::get('tourisms/{id}', [TourismController::class, 'show']);
    Route::post('tourisms/{id}', [TourismController::class, 'update']);
    Route::delete('tourisms/{id}', [TourismController::class, 'destroy']);
    Route::get('/tourisms/{tourism}/trips', [TourismController::class, 'getTripsByTourism']);
    Route::post('trips/{trip_offer}/book', [TripBookingController::class, 'store']);
    Route::get('trip-bookings/{trip_booking}', [TripBookingController::class, 'show']);
    Route::delete('trip-bookings/{trip_booking}', [TripBookingController::class, 'destroy']);

    Route::post('movies/{movie}/book', [MovieBookingController::class, 'store']);
    Route::get('/movie-bookings/{id}', [MovieBookingController::class, 'show']);
    Route::delete('/movie-bookings/{id}', [MovieBookingController::class, 'destroy']);


   
    Route::get('my-qrcodes', [MyQRCodeController::class, 'myQRCodes']);
    Route::delete('/my-qrcodes/{id}/{type}', [MyQRCodeController::class, 'destroy']);

    Route::get('/favorites', [FavoritesController::class, 'index']);
    Route::post('/favorites', [FavoritesController::class, 'store']);
    Route::delete('/favorites', [FavoritesController::class, 'destroy']);

    Route::get('hotels', [HotelController::class, 'index']);
    Route::post('hotels', [HotelController::class, 'store']);
    Route::get('hotels/{id}', [HotelController::class, 'show']);
    Route::post('hotels/{id}', [HotelController::class, 'update']);
    Route::delete('hotels/{id}', [HotelController::class, 'destroy']);
    Route::get('hotels/{id}/rooms', [HotelController::class, 'rooms']);

    Route::get('rooms', [RoomController::class, 'index']);
    Route::post('rooms', [RoomController::class, 'store']);
    Route::get('rooms/{id}', [RoomController::class, 'show']);
    Route::post('rooms/{id}', [RoomController::class, 'update']);
    Route::delete('rooms/{id}', [RoomController::class, 'destroy']);

    Route::get('/carts', [CartController::class, 'index']);//cart
    Route::post('/cart/add', [CartController::class, 'addToCart']);//cart
    Route::get('/cart', [CartController::class, 'getCartItems']);//cart
    Route::delete('/cart/clear', [CartController::class, 'clearCart']);
    Route::delete('/cart/item/{product_id}', [CartController::class, 'deleteCartItem']);
    Route::post('/booktransport', [TransportationController::class, 'book']);///transportbok 30-8

    /////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('company/profile/dashboard', [CompanyProfileController::class, 'dashboardLink']);
    Route::post('store/card/data', [VisitorProfileController::class, 'storeCardData']);
    Route::post('store/wallet/data', [VisitorProfileController::class, 'storeWalletData']);
    Route::get('vistor/cards/{id}', [VisitorProfileController::class, 'getCardList']);
    Route::get('vistor/wallets/{id}', [VisitorProfileController::class, 'getWalletList']);
    Route::get('vistor/history/list/{id}', [VisitorProfileController::class, 'history']);

    Route::get('/allnotifications', [AuthController::class, 'getNotifications']);


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
   Route::get('/villages', [VillageController::class, 'index']);
   Route::post('/createvillages', [VillageController::class, 'store']);

   Route::get('reviews', [ReviewController::class,'index']);
   Route::post('reviews', [ReviewController::class,'store']);

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


   Route::post('screens/create', [ScreenController::class, 'createScreenWithSeats']);
// Get all screens for a cinema
    Route::get('cinemas/{cinema_id}/screens', [ScreenController::class, 'getScreens']);

// Get all seats for a specific screen
    Route::get('screens/{screen_id}/seats', [ScreenController::class, 'getSeats']);
// Book a seat for a screen
   Route::post('seats/book', [ScreenController::class, 'bookSeats']);



//transport
  Route::post('transports', [TransportController::class,'store']);
  Route::get('transports', [TransportController::class,'index']);
//supermarkets----14-8-2024
  Route::get('supermarkets', [SupermarketController::class,'index']);
  Route::post('supermarkets', [SupermarketController::class, 'store']);
  Route::get('/supermarkets/{id}', [SupermarketController::class, 'show']);
  Route::put('/supermarkets/{id}', [SupermarketController::class, 'update']);
  Route::delete('/supermarkets/{id}', [SupermarketController::class, 'destroy']);




//products 15-8-2024

// Route to create a new product
  Route::post('/products', [ProductController::class, 'store']);

// Route to get a list of all products
  Route::get('/products', [ProductController::class, 'index']);

// Route to get a single product by ID
  Route::get('/products/{id}', [ProductController::class, 'show']);

// Route to update a product by ID
  Route::put('/products/{id}', [ProductController::class, 'update']);

// Route to delete a product by ID
  Route::delete('/products/{id}', [ProductController::class, 'destroy']);
  Route::post('/products/{id}/increase-quantity', [ProductController::class, 'increaseQuantity']);
  Route::post('/products/{id}/decrease-quantity', [ProductController::class, 'decreaseQuantity']);

   Route::post('/offers', [OfferController::class, 'store']);
   Route::get('/transports', [TransportationController::class, 'index']);///transport 30-8

    Route::post('/createtransports', [TransportationController::class, 'store']);
    Route::get('/transports/{id}', [TransportationController::class, 'show']);
    Route::put('/transports/{id}', [TransportationController::class, 'update']);
    Route::delete('/transports/{id}', [TransportationController::class, 'destroy']);
   

    //////////////////////////////////////////////////////////////////////////////////////
    Route::post('room-offers', [RoomOfferController::class, 'store']);
    Route::get('room-offers', [RoomOfferController::class, 'index']);
    Route::get('room-offers/{id}', [RoomOfferController::class, 'show']);
    Route::post('/room-offers/book', [RoomOfferController::class, 'bookRoomOffer']);  

    Route::get('movies/{movie_id}/screens', [ScreenController::class, 'getScreensByMovie']);
    
    Route::get('enterprise-profile/{id}', [CompanyProfileController::class, 'enterpriseProfile']);
    

    Route::post('/room-bookings', [RoomBookingController::class, 'store']);
    Route::get('/room-bookings/{id}', [RoomBookingController::class, 'show']);
    Route::delete('/room-bookings/{id}', [RoomBookingController::class, 'destroy']);


    


});







