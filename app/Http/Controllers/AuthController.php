<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function register()
    {
        return view('pages.register');
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => "required|email|unique:users,email",
                'password' => "required|min:4|confirmed",
                'image' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ], 422);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs('user', $filename, 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'image' => $filename
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Registration Successfully',
        ]);
    }

    public function login()
    {
        return view('pages.login');
    }

    public function match(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'email' => "required|email",
                'password' => "required|min:4"
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ], 422);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return response()->json([
                'status' => true,
                'message' => 'Login Successfully..'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password..'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out..'
        ], 200);
    }

    public function profile()
    {
        $profile = Auth::user();
        return view('pages.profile', compact('profile'));
    }

    public function edit()
    {

        $data = User::where('id', Auth::id())->first();
        return view('pages.update', compact('data'));
    }


    public function update(Request $request)
    {
        $data = User::where('id', Auth::id())->first();
        $new = $data->image;
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($data->id),
            ],
            'image' => 'image|mimes:png,jpg,svg'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ], 422);
        }
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('user/' . $data->image);
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('user', $filename, 'public');
            $new = $filename;
        }

        $result = $data->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' =>  $new
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Profile Updated Successfully',
            'data' => $result
        ]);
    }
}
