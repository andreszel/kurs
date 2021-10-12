<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        return view('me.profile', [
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('me.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        // docs - validation, avalable validation rules
        //name, email, phone
        // Sposób 1, unique:users to dodatkowo trzeba obsłużyć bo user o takim mailu istnieje, trzeba zrobić sprawdzanie maila, ale oprócz naszego konta
        $request->validate([
            'email' => 'required|unique:users|email',
            //'email' => 'required|email',
            'name' => 'required|max:20 '
        ]);
        // Alternatywny Sposób
        /* $request->validate([
            'email' => ['required', 'unique:users', 'email'],
            'name' => ['required','max:20']
        ]); */

        //dd($request->all());

        return redirect()
            ->route('me.profile')
            ->with('status', 'Profil zaktualizowany');
    }
}
