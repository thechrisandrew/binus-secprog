<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Make sure the user is logged in
        $this->middleware('auth');
    }

    public function edit() {
        return view('profile')->with('user', Auth::user());
    }

    public function update(Request $request) {
        $request->validate([
            'username' => ['string', 'alpha_dash', 'max:30', Rule::unique('users')->ignore(Auth::user()->id)],
            'email' => ['string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
        ]);

        Auth::user()->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect(route('profile'));
    }

    public function updateAvatar(Request $request) {
        $user_id = Auth::user()->id;

        if(Storage::disk('local')->exists('tmp/avatars/' . $user_id . '.png')) {
            // get the avatar from the local filesystem temporary folder
            $avatar = Storage::disk('local')->get('tmp/avatars/' . Auth::user()->id . '.png');

            // save the avatar to the public folder on the current filesystem
            Storage::put('public/avatars/'. $user_id .'.png', $avatar);

            // delete the avatar from the local filesystem temporary folder
            Storage::disk('local')->delete('tmp/avatars/' . $user_id . '.png');
        }

        return redirect(route('profile'));
    }

    public function updatePassword(Request $request) {
        return redirect(route('profile'));
    }
}
