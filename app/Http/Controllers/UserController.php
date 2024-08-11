<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $allUsers = User::with('roles', 'news')->get();
        return view('admin.users.manage', compact('allUsers', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (Auth::id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {

            if (Auth::id() !== $user->id) {
                abort(403, 'Unauthorized action.');
            }

            $request->validate([
                'name' => 'sometimes|string|string:max:255',
                'bio' => 'nullable|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = [
                'name' => $request->name,
                'bio' => $request->bio,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image->storeAs('public/images/', $image->hashName());

                Storage::delete('public/images/' . $user->image);

                $data['image'] = $image->hashName();
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Successfully update the profile.',
                'redirect_url' => route('dashboard', $user->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->image) {
                Storage::delete('public/images/' . $user->image);
            }

            foreach ($user->news as $news) {
                if ($news->image) {
                    Storage::delete('public/images/' . $news->image);
                }
            }

            $user->news()->delete();
            $user->notifications()->delete();

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully delete the user.',
                'redirect_url' => route('admin.users.manage')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function assignRole(Request $request, User $user)
    {
        try {
            $request->validate([
                'role' => 'required:exist:roles,id'
            ]);

            $roleId = $request->input('role');
            $role = Role::findOrFail($roleId);

            $user->syncRoles([$role]);

            return response()->json([
                'success' => true,
                'message' => 'Successfully update the role.',
                'redirect_url' => route('admin.users.manage')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
