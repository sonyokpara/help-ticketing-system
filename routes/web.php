<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\TicketController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

    // $user = User::create([
    //     'name' => 'prince',
    //     'email' => 'prince@email.com',
    //     'password' => 'password'
    // ]);

    // dd($user);

    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('update.avatar');
    Route::post('/profile/avatar/ai', [AvatarController::class, 'generateAvatar'])->name('profile.avatar.ai');
});

require __DIR__.'/auth.php';

# Laravel Socialite Routes
Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');
 
Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    
    $user = User::firstOrCreate([
        'email' => $user->email,
    ], [
        'name' => $user->name ?? $user->nickname,
        'password' => 'password',
    ]);
 
    Auth::login($user);
 
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function(){
    Route::resource('/ticket', TicketController::class);
});
