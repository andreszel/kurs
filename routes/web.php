<?php

declare(strict_types=1);

//use App\Http\Middleware\RequestLog;

use App\Http\Middleware\Pagination;
use Illuminate\Support\Facades\Auth;
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

//Route::group(['middleware' => ['auth']], function () {
Route::middleware(['auth'])->group(function () {
    Route::get('/', 'Home\MainPage')
        ->name('home.mainPage');

    Route::get('users', 'UserController@list')
        ->name('get.users');

    Route::get('users/{userId}', 'UserController@show')
        ->name('get.user.show');
        //->middleware('can:admin-level');

    Route::get('user/profile/{id}/address', 'User\ShowAddress')
        ->where(['id' => '[0-9]+'])
        ->name('get.user.address');

    /* Route::get('users/{id}/profile', 'User\ProfileController@show')
        ->name('get.user.show'); */

    // Sposób 1
    /* Route::resource('games', 'GameQBuilderController')
        ->only([
            'index', 'show'
        ]); */

    // GAMES Query builder
    Route::group([
        'prefix' => 'b/games',
        'namespace' => 'Game',
        'as' => 'games.qb.'
    ], function () {
        Route::get('dashboard', 'GameQBuilderController@dashboard')
            ->name('dashboard');

        // Sposób 2
        Route::get('/', 'GameQBuilderController@index')
            ->name('list')
            ->middleware(Pagination::class);

        Route::get('/{gameId}', 'GameQBuilderController@show')
            ->name('show');
    });

    // GAMES Eloquent
    Route::group([
        'prefix' => 'e/games',
        'namespace' => 'Game',
        'as' => 'games.e.',
        'middleware' => ['profiling']
    ], function () {
        Route::get('dashboard', 'GameEloquentController@dashboard')
            ->name('dashboard');

        // Sposób 2
        Route::get('/', 'GameEloquentController@index')
            ->name('list')
            ->middleware(Pagination::class);

        Route::get('/{gameId}', 'GameEloquentController@show')
            ->name('show');
        //->middleware(['profiling']);
        //Route::middleware([RequestLog::class])->group(
        /* Route::middleware(['profiling'])->group(
            function () {
                Route::get('dashboard', 'GameEloquentController@dashboard')
                    ->name('dashboard');

                // Sposób 2
                Route::get('/', 'GameEloquentController@index')
                    ->name('list');

                Route::get('/{gameId}', 'GameEloquentController@show')
                    ->name('show');
            }
        ); */
    });

    // GAMES Eloquent
    Route::group([
        'prefix' => 'games',
        'namespace' => 'Game',
        'as' => 'games.',
        'middleware' => ['profiling']
    ], function () {
        Route::get('dashboard', 'GameController@dashboard')
            ->name('dashboard');

        // Sposób 2
        Route::get('/', 'GameController@index')
            ->name('list')
            ->middleware(Pagination::class);

        Route::get('/{gameId}', 'GameController@show')
            ->name('show');
    });

    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // USER - ME
    Route::group([
        'prefix' => 'me',
        'namespace' => 'User',
        'as' => 'me.'
    ], function () {
        Route::get('profile', 'UserController@profile')
            ->name('profile');
        Route::get('edit', 'UserController@edit')
            ->name('edit');
        Route::post('update', 'UserController@update')
            ->name('update');
        Route::post('profile/avatar/delete', 'UserController@deleteAvatar')
            ->name('avatar.delete');
        // listing
        Route::get('games', 'GameController@list')
            ->name('games.list');
        // dodanie
        Route::post('games', 'GameController@add')
            ->name('games.add');
        Route::delete('games', 'GameController@remove')
            ->name('games.remove');
        Route::post('games/rate', 'GameController@rate')
            ->name('games.rate');
    });
});

Auth::routes();

/* Route::resource('admin/games', 'Game\GameQBuilderController')
    ->only([
        'store', 'create', 'destroy'
    ]); */
/* Route::get('/goodbye/{name}', function (string $name) {
    return 'Goodbaye: ' . $name;
}); */

/* Route::get('/example', function () {
    return 'here is method get';
}); */

/* $uri = '/example';
Route::get($uri, fn () => 'hello here is get with arrow function');
Route::post($uri, fn () => 'hello here is post with arrow function');
Route::put($uri, fn () => 'hello here is put with arrow function');
Route::patch($uri, fn () => 'hello here is patch with arrow function');
Route::delete($uri, fn () => 'hello here is delete with arrow function');
Route::options($uri, fn () => 'hello here is options with arrow function'); */

//dla wybranych metod
//Route::match(['get', 'post'], '/match', fn () => 'here is match for get and post with arrow function');

//wszystkie metody
//Route::any('/all', fn () => 'all methods');

//pominięcie callback function, direct redirect to view
/* Route::view('/view/route', 'route.view');
Route::view(
    '/view/route/var1',
    'route.viewParam',
    [
        'param1' => 'var1 - it is our route',
        'name' => 'Andrew'
    ]
);

Route::get('posts/{postId}/title/{title}', function (int $postId, string $title) {
    var_dump($title);
    dd($postId);
});

Route::get('users-f/{nick?}', function (string $nick = null) {
    dd($nick);
});

// domyślna wartość
Route::get('users-default-value/{nick?}', function (string $nick = 'Andrew') {
    dd($nick);
})->where(['nick' => '[a-z]+']);

//wyrażenie regularne, np. tylko a-z
Route::get('users-regexp/{nick}', function (string $nick) {
    dd($nick);
})->where(['nick' => '[a-z]+']);
// example url for response object
Route::get('response/example/{id}', 'UserController@responseExample')
    ->where(['id' => '[0-9]+'])
    ->name('get.response.example');

Route::get('users', 'UserController@list')
    ->name('get.users');

Route::get('users/test/{id}', 'UserController@testShow')
    ->name('get.users.test.show');

Route::post('users/test/{id}', 'UserController@testStore')
    ->name('post.users.test.store');

Route::get('user/profile/{id}', 'User\ProfileController@show')
    ->name('get.user.profile');

Route::get('user/profile/{id}/address', 'User\ShowAddress')
    ->where(['id' => '[0-9]+'])
    ->name('get.user.address');

Route::resource('games', GameController::class);

// section 7
Route::get('section/6/blade/example/{id}', 'UserController@bladeExample')
    ->where(['id' => '[0-9]+'])
    ->name('get.blade.example');

// section 8
Route::get('users/show/{userId}', 'UserController@show')
    ->name('get.user.show');
Route::get('users/list', 'UserController@list')
    ->name('get.user.list'); */

// dzięki poniższym zapisom z chain only możemy sobie zdefiniować, które adresy mają być widoczne dla wszystkich, a które tylko dla admina lub w adminie
/* Route::resource('games', GameController::class)
    ->only([
        'index', 'show'
    ]); */

/* Route::resource('admin/games', GameController::class)
    ->only([
        'create', 'store', 'destroy'
    ]); */
