<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\HelloController;

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

Route::get('users', 'UserController@list')
    ->name('get.users');

Route::get('users/test/{id}', 'UserController@testShow')
    ->name('get.users.test.show');

Route::post('users/test/{id}', 'UserController@testStore')
    ->name('post.users.test.store');

Route::get('user/profile/{id}', 'User\ProfileController@show')
    ->name('get.user.profile');

Route::get('user/profile/{id}/address', 'User\ShowAddress')
    ->where(['id'=>'[0-9]+'])
    ->name('get.user.address');

Route::resource('games', GameController::class);

// dzięki poniższym zapisom z chain only możemy sobie zdefiniować, które adresy mają być widoczne dla wszystkich, a które tylko dla admina lub w adminie
/* Route::resource('games', GameController::class)
    ->only([
        'index', 'show'
    ]); */

/* Route::resource('admin/games', GameController::class)
    ->only([
        'create', 'store', 'destroy'
    ]); */