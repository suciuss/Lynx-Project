<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
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


use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('login');
});

Auth::routes(['verify' => true]);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware('verified');

Auth::routes();

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/second-page',[App\Http\Controllers\HomeController::class, 'secondPage']);

    Route::get('/edit-user-view/{userId}', [App\Http\Controllers\HomeController::class, 'editUserView']);

    Route::post('/editUser', [App\Http\Controllers\HomeController::class, 'editUser'])->name('editUser');

    Route::post('/delete-user', [App\Http\Controllers\HomeController::class, 'deleteUser'])->name('deleteUser');

    Route::post('/unverify-user', [App\Http\Controllers\HomeController::class, 'unverifyUser'])->name('deleteUser');

    Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');

    Route::get('/terms-and-conditions', [App\Http\Controllers\TermsController::class, 'index'])->name('termsAndConditions');

    Route::get('/create-terms-view',  [App\Http\Controllers\TermsController::class, 'createTermsView']);

    Route::post('/create-terms', [App\Http\Controllers\TermsController::class, 'createTerms'])->name('createTerms');

    Route::post('/publish-terms/{termsId}', [App\Http\Controllers\TermsController::class, 'publishTerms'])->name('publishTerms');

    Route::post('/edit-terms', [App\Http\Controllers\TermsController::class, 'editTerms'])->name('editTerms');

    Route::get('/edit-terms-view/{termsId}', [App\Http\Controllers\TermsController::class, 'editTermsView'])->name('editTermsView');

    Route::post('/delete-terms/{termsId}', [App\Http\Controllers\TermsController::class, 'deleteTerms'])->name('deleteTerms');

    Route::post('/accept-new-terms' , [App\Http\Controllers\TermsController::class, 'acceptLatestTerms'])->name('acceptLatestTerms');

    Route::get('/accepted-terms', [App\Http\Controllers\TermsController::class, 'acceptedTerms'])->name('acceptedTerms');
});

Route::get('/terms', [App\Http\Controllers\FrontController::class, 'showTerms'])->name('terms');
