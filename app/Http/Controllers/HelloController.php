<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function hello()
    {
        return view('hello.hello');
    }

    public function hello_param(string $name)
    {
        return view('hello.hello_param', ['requestName' => $name]);
    }
}
