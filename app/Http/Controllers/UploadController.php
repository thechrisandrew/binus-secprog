<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Image;
use Auth;

class UploadController extends Controller
{
    public function store(Request $request) {

        $validator = Validator::make($request->all(),
        [
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ],
        [
            'avatar.max' => 'File must be less than 2MB'
        ]
        );

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        if($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $avatar = Image::make($file)->fit(200)->encode('png');

            // save avatar to tmp folder in local storage
            Storage::disk('local')->put('tmp/avatars/' . Auth::user()->id . '.png', $avatar);

            return "ok";
        }

        return "ok";
    }
}
