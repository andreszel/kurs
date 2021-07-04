<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/goodbye/{name}', function (string $name) {
    return 'Goodbaye: ' . $name;
});

/* Route::get('/example', function () {
    return 'here is method get';
}); */

$uri = '/example';
Route::get($uri, fn () => 'hello here is get with arrow function');
Route::post($uri, fn () => 'hello here is post with arrow function');
Route::put($uri, fn () => 'hello here is put with arrow function');
Route::patch($uri, fn () => 'hello here is patch with arrow function');
Route::delete($uri, fn () => 'hello here is delete with arrow function');
Route::options($uri, fn () => 'hello here is options with arrow function');

//dla wybranych metod
Route::match(['get', 'post'], '/match', fn () => 'here is match for get and post with arrow function');

//wszystkie metody
Route::any('/all', fn () => 'all methods');

//pominięcie callback function, direct redirect to view
Route::view('/view/route', 'route.view');
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

Route::get('users/{nick?}', function (string $nick = null) {
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
