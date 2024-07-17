<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function ratingCreate()
    {
        $products = Product::all();
        return view('ratings.create_ratings',compact('products'));
    }

    public function getRating(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $ratingId = Rating::find($request->input('id'));

        if ($ratingId) {
            return response()->json([
                'success' => true,
                'data' => $ratingId
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Rating not found'
            ], 404);
        }

    }

    public function ratingtInsert(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'product_id' => 'required',
            'customer_name' => 'required',
            'star' => 'required',
            'review' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $rating = Rating::create([
            'product_id' => $request->input('product_id'),
            'customer_name' => $request->input('customer_name'),
            'star' => $request->input('star'),
            'review' => $request->input('review'),
        ]);


        return response()->json(['message' => 'Rating created successfully', 'rating' => $rating], 201);

    }
    public function ratings()
    {
        $ratings = Rating::with('product')->get();
        return response()->json([
            'success' => true,
            'message' => 'Rating Data successfully',
            'result' => $ratings
        ], 200);

    }

    public function ratingUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:rating,id',
            'product_id' => 'required',
            'customer_name' => 'required',
            'star' => 'required',
            'review' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation fails',
                'error' => $validator->errors()
            ], 401);
        }

        $ratings = Rating::find($request->input('id'));

        if (is_null($ratings)) {
            return response()->json(['message' => 'Rating not found'], 404);
        }

        $ratings->update([
            'id' => $request->input('id'),
            'product_id' => $request->input('product_id'),
            'customer_name' => $request->input('customer_name'),
            'star' => $request->input('star'),
            'review' => $request->input('review'),
        ]);


        return response()->json([
            'message' => 'User updated successfully',
            'user' => $ratings,
        ], 200);

    }
    public function ratingDestroy(Request $request)
    {
        $ratings = Rating::find($request->input('id'));
        if (!$ratings) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $ratings->delete();
        return response()->json(['message' => 'Rating deleted successfully']);

    }


}
