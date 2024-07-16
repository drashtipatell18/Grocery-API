<?php

namespace App\Http\Controllers;
use App\Models\UserAddress;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function userAddress(){
        $useraddress = UserAddress::with('user')->get();
        return response()->json([
            'success' => true,
            'message' => 'Users Address Data successfully',
            'result' => $useraddress
        ], 200);


    }
    public function userAddressCreate(){
        $users = User::pluck('name', 'id');
        return view('user.create_useraddress',compact('users'));
    }
    public function userAddressInsert(Request $request){
        $validateRequest = Validator::make($request->all(), [
            'address' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $user = UserAddress::create([
            'user_id'      => $request->input('user_id'),
            'address'  => $request->input('address'),
        ]);


        return response()->json(['message' => 'User Address created successfully', 'user' => $user], 201);

    }

    public function userAddressUpdate(Request $request, $id){
        $validateRequest = Validator::make($request->all(), [
            'address' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $useraddress = UserAddress::find($id);

        if (is_null($useraddress)) {
            return response()->json(['message' => 'User Address not found'], 404);
        }

        $useraddress->update([
            'user_id'      => $request->input('user_id'),
            'address'  => $request->input('address'),
        ]);

        return response()->json([
            'message' => 'User Address updated successfully',
            'cart' => $useraddress,
        ], 200);


    }
    public function userAddressDestroy($id){
        $useraddress = UserAddress::find($id);
        if (!$useraddress) {
            return response()->json(['message' => 'User Address not found'], 404);
        }
        $useraddress->delete();
        return response()->json(['message' => 'User Address deleted successfully']);
    }
}
