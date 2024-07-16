<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function wishlistCreate()
    {
        $users = User::all();
        $products = Product::all();
        return view('wishlist.create_wishlist', compact('users', 'products'));
    }

    public function wishlistInsert(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $wishlist = Wishlist::create([
            'user_id'      => $request->input('user_id'),
            'product_id'     => $request->input('product_id'),
        ]);


        return response()->json(['message' => 'Wishlist created successfully', 'wishlist' => $wishlist], 201);

    }
    public function wishlists()
    {
        $wishlists = Wishlist::all();
        return response()->json([
            'success' => true,
            'message' => 'Wishlist Data successfully',
            'result' => $wishlists
        ], 200);

    }



    public function wishlistUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation fails',
                'error' => $validator->errors()
            ], 401);
        }

        $wishlist = Wishlist::find($id);

        if (is_null($wishlist)) {
            return response()->json(['message' => 'Wishlist not found'], 404);
        }

        $wishlist->update([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
        ]);


        return response()->json([
            'message' => 'WishList updated successfully',
            'user' => $wishlist,
        ], 200);

    }

    public function wishlistDestroy($id)
    {
        $wishlist = Wishlist::find($id);
        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist not found'], 404);
        }
        $wishlist->delete();

        return response()->json(['message' => 'Wishlist deleted successfully']);

    }

}
