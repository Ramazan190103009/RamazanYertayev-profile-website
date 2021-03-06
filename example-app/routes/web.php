<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactForm;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\localization_controller;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UploadController;
use App\Http\Middleware\Localization;
use App\Models\Post;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

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
Route::get('/portfolio', function () {
    return view('portfolio');
})->name('portfolio');

Route::get('post/create', function(){
    DB::table('post')->insert([
        'tittle' => 'Math Programming',
        'body' => 'Math Programming is a blog about what no good programmer can do without - about mathematics. Articles detail the methods of machine learning, quantum computing, algorithmic theory, procedural graphics generation, and more. Any note that describes an algorithm also contains its implementation in Python - it may come in handy.'
    ]);
});

Route::get('post', [BlogController::class, 'index']);
Route::get('post2/create', function(){
     return view('blog.create');
});

Route::post('post2/create', [BlogController::class, 'store'])->name('add-post');

//TEST ROUTE
Route::get('post/{id}', [BlogController::class, 'get_id']);

//UPLOAD FILE ROUTE
Route::get('upload_form', [UploadController::class, 'show']);
Route::post('upload_form', [UploadController::class, 'upload'])->name('upload');

Route::get('upl', [UploadController::class, 'index']);
Route::post('upload', [UploadController::class, 'upload2'])->name('upload_db');

//Mail routes
Route::get('send_mail', [MailController::class, 'sendEmail']);

//Localization
Route::get('/portfolio/{locale}', function($locale){
  App::setLocale($locale);
  return view('portfolio');
});
//localization with switches
Route::get('lang/{lang}', function($locale){
    session()->put('locale', $locale);
    return Redirect()->back();
});

Route::get('/contact-us', [ContactForm::class, 'contact']);
Route::post('/send-message', [ContactForm::class, 'sendEmail'])->name('sent-email');