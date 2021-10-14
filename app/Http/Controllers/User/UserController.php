<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfile;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;

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
        $user = Auth::user();
        $data = $request->validated();

        //avatar
        $path = null;
        if(!empty($data['avatar']))
        {
            $path = $data['avatar']->store('avatars', 'public');
            //$extAvatar = $data['avatar']->extension();
            //$path = $data['avatar']->storeAs('avatars', Auth::id() . '.' . $extAvatar, 'public');
    
            if($path) {
                //usuwamy stary plik
                Storage::disk('public')->delete($user->avatar);
                $data['avatar'] = $path;
            }
        }else{
            $data['avatar'] = $user->avatar;
        }

        // logika zapisu danych, które przeszły już walidację, w klasie UpdateUserProfile
        $this->userRepository->updateModel($user, $data);

        return redirect()
            ->route('me.profile')
            ->with('success', 'Profil zaktualizowany');
    }

    public function deleteAvatar()
    {
        //$user = User::find(Auth::id());
        $user = Auth::user();
        if(FacadesFile::exists('storage/' . $user->avatar))
        {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        return redirect()
            ->route('me.edit')
            ->with('success', 'Avatar usunięty');
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
            ->with('success', 'Profil zaktualizowany');
    }
}
