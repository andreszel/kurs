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

/* Route::get('/', function () {
    return view('welcome');
});

$example = '/example';
Route::get($example, fn() => 'Example');
Route::get($example.'/{param1}', function($param1){
    return 'Hello. Param: '. $param1;
}); */

//wersja jeżeli na początku zrobimy use
//Route::get('/hello', [HelloController::class, 'hello']);
//wersja jeżeli na początku nie będzie use
//Route::get('/hello2', 'App\Http\Controllers\HelloController@hello');
//wersja jeżeli w RouteServiceProvider zmienimy namespace

Route::get('/hello3', 'HelloController@hello');

Route::get(
    '/hello_param/{name}',
    'HelloController@hello_param'
)->where(['name'=>'[a-zA-Z]+']);

/* Route::get('goodbye/{name}', function (string $name) {
    return 'Goodbye: '. $name;
});

$uri = '/route_methods';
Route::get($uri, fn() => 'Jestem: GET');
Route::post($uri, fn() => 'Jestem: POST');
Route::put($uri, fn() => 'Jestem: PUT');
Route::patch($uri, fn() => 'Jestem: PATCH');
Route::delete($uri, fn() => 'Jestem: DELETE');
Route::options($uri, fn() => 'Jestem: OPTIONS');


Route::match(['get', 'post'], '/match', function () {
    return 'Jestem GET lub POST';
});

Route::any('/any', function () {
    return 'All in one: ANY';
});

Route::view('/route-view', 'route.view');
Route::view(
    '/route-view-param',
    'route.viewParam',
    ['param1' => 'VAR1 - zmienna', 'name' => 'Andrew']
);
Route::view(
    '/route-view-param-new',
    'route.viewParam',
    ['param1' => 'VAR1 - zmienna', 'name' => 'Robert']
);

Route::get('/posts/{postId}/{title}', function (int $postId, string $title) {
    var_dump($postId);
    dd($title);
});
// parametr nieobowiązkowy ? oraz ustawiamy null, obsługa adresu /users oraz adresów /users/*
//Route::get('/users/{nick?}', function (string $nick = null) {
//domyślny wartość parametru
Route::get('/users/{nick?}', function (string $nick = 'Andrew') {
    dd($nick);
});
//warunek, który muszą spełnić przesłane parametry
Route::get('/users/where/{nick}', function (string $nick) {
    dd($nick);
})->where(['nick'=>'[a-z]+']);
//nazwa trasy
Route::get('/route-name', function () {
    return 'Route name';
})->name('route.item');
Route::get('/route-name/{id}', function ($id) {
    return 'Route name od: ' . $id;
})->name('route.item.id');
//test route name
Route::get('/test-route-name', function () {
    $url = route('route.item');
    dump($url);
});
Route::get('/test2-route-name', function () {
    //pełny adres z domeną
    $url = route('route.item.id', ['id' => 3434]);
    //adres bez domeny, 3 parametr default true
    //$url = route('route.item.id', ['id' => 3434], false);
    dump($url);
}); */