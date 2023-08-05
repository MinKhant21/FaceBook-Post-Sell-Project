<?php

use App\Http\Controllers\GraphController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/post-sales-to-facebook', [FacebookSalesController::class, 'postSalesToFacebook']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/post',[PostController::class,'index']);
Route::middleware('auth')->group(function()
{
    Route::resource('post',PostController::class);
    Route::post('/getall',[PostController::class,'getall'])->name('getall');
    Route::post('/getmodal', [PostController::class,'getmodal'])->name('getmodal');

    Route::resource('profile',ProfileController::class);
    Route::get('/profile',[ProfileController::class,'profile'])->name('profile');

    // Route::get('profile', 'ProfileController@index')->name('profile');
    Route::get('/facebook', [ProfileController::class,'redirectToFacebookProvider'])->name('facebook');
    Route::get('/facebook/callback',[ProfileController::class,'handleProviderFacebookCallback']);
    Route::post('facebook_page_id', [ProfileController::class,'facebook_page_id'])->name('facebook_page_id');
    
    Route::post('page',[GraphController::class,'publishToPage'])->name('page');

    Route::get('auth/facebook',function(){
        return Socialite::driver('facebook')->redirect();
    });
});


