<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfile;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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

    // obiekt powstaje przez uruchomieniem kontrolera, i walidacja jest również przed uruchomieniem kontrolera
    public function update(UpdateUserProfile $request)
    {
        // logika zapisu danych, które przeszły już walidację, w klasie UpdateUserProfile
        $this->userRepository->updateModel(
            Auth::user(), $request->validated()
        );

        return redirect()
            ->route('me.profile')
            ->with('status', 'Profil zaktualizowany');
    }

    public function updateValidationRules(Request $request)
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
