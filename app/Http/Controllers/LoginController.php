<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();

                if ($remember) {
                    Cookie::queue('email', $request->email, 120);
                    Cookie::queue('password', $request->password, 120);
                } else {
                    Cookie::queue(Cookie::forget('email'));
                    Cookie::queue(Cookie::forget('password'));
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => $user,
                    'redirect_url' => route('dashboard')
                ]);
            } else {
                throw new \Exception('Your email/password is incorrect');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            
            Cache::forget('user-is-online-' . $userId);
            Cache::forget('user-online-expiration-' . $userId);

            Auth::logout();
        }

        return redirect()->route('index');
    }

    public function register()
    {
        return view('register');
    }

    public function registerSubmit(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $memberRole = Role::where('name', 'Writer')->first();
            if ($memberRole) {
                $user->assignRole($memberRole);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Role Member not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Register successful',
                'user' => $user,
                'redirect_url' => route('login')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
