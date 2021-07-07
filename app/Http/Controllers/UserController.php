<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        return view('user.list');
    }

    public function testShow(Request $request, int $id)
    {
        $uri = $request->path();
        $url = $request->url();
        $fullUrl  = $request->fullUrl();
        $httpMethod = $request->method();

        if($request->isMethod('post')){
            dump('To jest POST');
        }
        if($request->isMethod('get')){
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
        $hasParams = $request->has(['nameTest','testtt']);
        //czy którykowliek z parametrów został przesłany
        $hasAnyParams = $request->hasAny(['nameTest','testtt']);
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
        if(!$request->isMethod('post')){
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
