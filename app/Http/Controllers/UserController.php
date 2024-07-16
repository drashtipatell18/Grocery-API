<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function users()
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'message' => 'Users Data successfully',
            'result' => $users
        ], 200);
    }
    public function userCreate()
    {
        return view('user.create_user');
    }

    public function userInsert(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'mobile_no' => 'required',
            'password' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }


        $user = User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'address'  => $request->input('address'),
            'mobile_no'   => $request->input('mobile_no'),
            'password' => Hash::make($request->password),
        ]);


        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }



    public function userUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'mobile_no' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation fails',
                'error' => $validator->errors()
            ], 401);
        }

        $users = User::find($id);

        if (is_null($users)) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $users->update([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'address'  => $request->input('address'),
            'mobile_no'   => $request->input('mobile_no'),
            'password' => Hash::make($request->password),
        ]);


        return response()->json([
            'message' => 'User updated successfully',
            'user' => $users,
        ], 200);
    }

    public function userDestroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    // public function myProfile()
    // {
    //     if (Auth::check()) {
    //         $userid = Auth::user()->id;
    //         $users = User::with('role')->find($userid);
    //     }
    //     $roles = Role::pluck('role_name', 'id');
    //     return view('admin.user_profile', compact('users', 'roles'));
    // }

    // public function editProfile($id)
    // {
    //     if (Auth::check()) {
    //         $users = User::find($id);
    //     }
    //     return view('admin.user_profile', compact('users'));
    // }

    public function Profileupdate(Request $request, $id)
    {

        $validateRequest = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'mobile_no' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $users = User::find($id);

        $users->update([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'address'   => $request->input('address'),
            'mobile_no'  => $request->input('mobile_no'),
        ]);

        return redirect()->route('myprofile')->with('success', 'Profile updated successfully');
    }
}
