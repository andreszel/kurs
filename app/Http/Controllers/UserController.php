<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Faker\Factory;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $users = [];
        $usersEmpty = [];
        $faker = Factory::create();
        $count = $faker->numberBetween(3,15);
        for($i = 0; $i < $count; $i++) {
            $users[] = [
                'id' => $faker->numberBetween(1,1000),
                'name' => $faker->firstName
            ];
        }

        $faker_session = Factory::create();
        $ok = $faker_session->numberBetween(0,1);

        $session = $request->session();
        $session->flash('ok', $ok);

        return view('user.list', [
            'users' => $users
        ]);
    }

    public function show(Request $request, int $userId)
    {
        $faker = Factory::create();
        $user = [
            'id' => $userId,
            'name' => $faker->name,
            'firstName' => $faker->firstName,
            'lastName' => $faker->lastName,
            'city' => $faker->city,
            'age' => $faker->numberBetween(12,25),
            'html' => '<b>Bold HTML</b>'
        ];

        return view('user.show', [
            'user'=>$user,
            'nick' => true
        ]);
    }

    public function bladeExample(Request $request, int $id)
    {
        return view('user.show', [
            'id' => $id,
            'example' => 'show',
            'titleName' => 'Games - title nadpisany w akcji'
        ]);
    }

    public function responseExample(Request $request, int $id)
    {
        //tekst
        return "Zwykły tekst $id";

        // Response object
        /* return response(
            "<h3>Obiekt response. ID: $id</h3>",
            200,
            ['Content-Type' => 'text/plain']
        ); */

        //Chain
        /* return response("<h3>Obiekt response. ID: $id</h3>")
            ->setStatusCode(200)
            ->header('Content-Type', 'text/html')
            ->header('Own-Header', 'Laravel'); */

        // With cookies
        /* return response("<h3>Cookie, MIX, Obiekt response. ID: $id</h3>", 200)
            ->header('Content-Type', 'text/html')
            ->cookie('my_cookie', 'brownie', 10);//czas w minutach */

        // Redirect
        //return redirect('users');

        // Redirect by route
        //return redirect()->route('get.users');
        //return redirect()->route('get.user.address', ['id' => $id]);

        // Redirect to controller
        //return redirect()->action('UserController@list');
        //return redirect()->action('User\ShowAddress', ['id' => $id]);

        // Redirect to other site
        //return redirect()->away('https://mentorzy.it');

        //when we need set status header itp

        // response view
        /* return response()
            ->view('user.profile', ['id'=>$id])
            ->header('Content-Type', 'text/html'); */
        // helper do helpera view
        //return view('user.profile', ['id'=>$id]);

        // set as default: Content-Type: application/json
        //return response()->json(['id' => $id]);
    }

    public function testShow(Request $request, int $id)
    {
        $uri = $request->path();
        $url = $request->url();
        $fullUrl  = $request->fullUrl();
        $httpMethod = $request->method();

        if ($request->isMethod('post')) {
            dump('To jest POST');
        }
        if ($request->isMethod('get')) {
            dump('To jest GET');
        }

        //świadome pobranie danych
        $name = $request->input('name');
        //metoda input przyjmuje drugi domyślny parametr
        $lastName = $request->input('lastName', 'Kowalski');
        //tablica z input
        $game1 = $request->input('games.0');
        $game2 = $request->input('games.1.name');

        $allQuery = $request->query();

        $nameQuery = $request->query('name');
        $lastNameQuery = $request->query('name', 'Nowak');

        $expired = $request->boolean('expired');

        //jeżeli chcemy sprawdzić, czy parametr został przesłany
        $hasName = $request->has('nameTest');
        //czy kilka parametrów zostało przesłane
        $hasParams = $request->has(['nameTest', 'testtt']);
        //czy którykowliek z parametrów został przesłany
        $hasAnyParams = $request->hasAny(['nameTest', 'testtt']);
        //sprawdzanie ciasteczek, tablica ciasteczek
        $cookies = $request->cookies();
        //pobranie konkretnego ciasteczka analogicznie, wartość domyślna
        $cookieName = $request->cookies('myCookie', 'Delicje');

        dump($uri, $url, $fullUrl, $httpMethod, $name, $lastName, $game1, $game2, $allQuery, $nameQuery, $lastNameQuery, $expired, $hasName);

        dump($request);

        // wszystkie parametry
        $all = $request->all();
        dump($all);

        dd($id);
    }

    public function testStore(Request $request, int $id)
    {
        if (!$request->isMethod('post')) {
            return 'To jest POST';
        }

        // wszystkie parametry, query i body
        $all = $request->all();
        //tylko parametry z query
        $allQuery = $request->query();

        echo "ALL QUERY\n\n";
        print_r($allQuery);
        echo "\n\n";
        //dd();
        echo "ALL\n\n";
        var_dump($all);
        dd();
    }
}
