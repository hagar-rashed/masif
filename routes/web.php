<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BookingController;
use App\Http\Controllers\Dashboard\OfferController;
use App\Http\Controllers\Dashboard\TripController;
use App\Http\Controllers\Dashboard\UnitController;
use App\Http\Controllers\Dashboard\QRCodeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth')->group(function () {

    //Route::resource('trips', TripController::class);
    Route::get('createTrip', [TripController::class, 'create'])->name('createTrip');
    Route::post('storeTrip', [TripController::class, 'store'])->name('storeTrip');
    Route::get('tripIndex', [TripController::class, 'index'])->name('tripIndex');
    Route::get('editTrip/{id}', [TripController::class, 'edit'])->name('editTrip');
    Route::put('updateTrip/{id}', [TripController::class, 'update'])->name('updateTrip');
    Route::delete('destroyTrip/{id}', [TripController::class, 'destroy'])->name('destroyTrip');
});
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

// Localization Routes
Route::get('language/{locale}', function ($locale) {

    app()->setLocale($locale);

    session()->put('locale', $locale);

    return redirect()->back();
})->name('language');

Route::middleware('localization')->group(function () {



    Route::prefix('admin')->namespace('Dashboard')->group(function () {

        /* Auth Routes */
        Route::get('login', 'AuthController@showLoginForm')->name('admin.login');
        Route::post('login', 'AuthController@login')->name('admin.login.post');
        Route::get('logout', 'AuthController@logout')->name('admin.logout');
        Route::get('reset-password', 'AuthController@reset')->name('admin.reset');
        Route::post('send-link', 'AuthController@sendLink')->name('admin.sendLink');
        Route::get('changePassword/{code}', 'AuthController@changePassword')->name('admin.changePassword');
        Route::post('update-password', 'AuthController@updatePassword')->name('admin.updatePassword');
    });

    Route::prefix('admin')->middleware('auth')->namespace('Dashboard')->name('admin.')->group(function () {

        Route::get('/', 'DashboardController@home')->name('home');

        // Route::resource('categories', 'CategoryController');

        // Route::resource('articles', 'ArticleController');
        // Route::post('/delete-image', 'ArticleController@deleteImage')->name('delete-image');

        // Route::resource('services', 'ServiceController');

        // Route::resource('values', 'VillageController');

        // Route::resource('solutions', 'SolutionController');

        // Route::resource('brands', 'BrandController');

        // Route::resource('partners', 'PartnerController');

        // Route::resource('clients', 'CustomerController');
        // Route::delete('delete-client/{id}', 'CustomerController@destroy')->name('clients.delete');

        // Route::resource('jobs', 'JobVacancyController');

        // Route::resource('sectors', 'SectorController');

        // Route::get('settings/edit', 'SettingController@edit')->name('settings.edit');
        // Route::patch('settings/update', 'SettingController@update')->name('settings.update');

        // Route::get('job-applications', 'JobApplicationController@index')->name('job-applications.index');
        // Route::delete('job-applications/{id}', 'JobApplicationController@deleteMsg')->name('job-applications.deleteMsg');

        // Route::get('contacts', 'ContactController@index')->name('contacts.index');
        // Route::get('contacts/{id}', 'ContactController@show')->name('contacts.show');
        // Route::get('contacts/{id}/reply', 'ContactController@showReplyForm')->name('contacts.reply');
        // Route::post('contacts/send-reply', 'ContactController@sendReply')->name('contacts.sendReply');
        // Route::delete('contacts/{id}', 'ContactController@deleteMsg')->name('contacts.deleteMsg');

        // Route::get('mail-list', 'MailListController@index')->name('mail.index');
        // Route::delete('mail-list/{id}', 'MailListController@deleteMail')->name('mail.deleteMail');

        Route::get('profile', 'ProfileController@getProfile')->name('profile');
        Route::post('update-profile', 'ProfileController@updateProfile')->name('update_profile');

        //villages
        Route::resource('villages', 'VillageController');

        //units
        Route::resource('units', 'UnitController');

        //Bookings
        Route::resource('booking', 'BookingController');
        //---------------QRCode---------------------------
        Route::resource('qrcodes', 'QRCodeController');
        Route::delete('delete-qrcode/{id}', 'QRCodeController@destroy')->name('qrcodes.delete');


        //-------------------- Offers ---------------------------
        Route::prefix('offers')->as('offers.')->group(function () {
            Route::get('/', [OfferController::class, 'index'])->name('index');
            Route::get('/create', [OfferController::class, 'create'])->name('create');
            Route::post('/store', [OfferController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [OfferController::class, 'edit'])->name('edit');
            Route::patch('/update/{id}', [OfferController::class, 'update'])->name('update');
            Route::delete('/destory/{id}', [OfferController::class, 'destroy'])->name('destroy');
        });
       


    });



    Route::namespace('Site')->name('site.')->group(function () {

        Route::get('/', 'HomeController@index')->name('home');

        Route::get('about-us', 'HomeController@about')->name('about');

        Route::get('solutions', 'HomeController@solutions')->name('solutions');

        Route::get('sectors', 'HomeController@sectors')->name('sectors');

        Route::get('partners', 'BrandController@partners')->name('partners');

        Route::get('clients', 'BrandController@clients')->name('clients');

        // Articles Routes
        Route::get('news', 'ArticleController@index')->name('news.index');
        Route::get('news-details/{id}', 'ArticleController@show')->name('news.show');
        Route::get('news-filter/{id}', 'ArticleController@filter')->name('news.filter');

        // Jobs Routes
        Route::get('jobs', 'JobController@index')->name('jobs.index');
        Route::get('jobs-details/{id}', 'JobController@show')->name('jobs.show');
        Route::get('apply-job/{id}', 'JobController@apply')->name('jobs.apply');
        Route::post('submit-job-application/{id}', 'JobController@submitJobApplication')->name('jobs.submit-job-application');

        // Contact Routes
        Route::get('contact', 'ContactController@showForm')->name('contact');
        Route::post('contact/send', 'ContactController@sendContact')->name('contact.sendContact');

        // Mail List Routes
        Route::post('mail-list', 'HomeController@mailList')->name('mail');

        // search
        Route::get('search', 'HomeController@search')->name('search');

        // internships
        Route::get('internships', 'JobController@internships')->name('internships.index');
    });
});
