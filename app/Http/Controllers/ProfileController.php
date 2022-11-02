<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
}
