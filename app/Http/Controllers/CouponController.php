<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function coupon()
    {
        $coupons = Coupon::all();

        return response()->json([
            'success' => true,
            'message' => 'Coupans Data successfully',
            'result' => $coupons
        ], 200);
    }


    public function getCoupon(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $couponId = Coupon::find($request->input('id'));

        if ($couponId) {
            return response()->json([
                'success' => true,
                'data' => $couponId
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not found'
            ], 404);
        }

    }

    public function couponCreate()
    {
        return view('coupon.create_coupon');
    }
    public function couponInsert(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'name' => 'required',
            'coupon_code' => 'required',
            'discount' => 'required',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'start_date' => 'required',
            'expiry_date' => 'required',
            'minimum_order_amount' => 'required',
        ]);
        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }
        $filename = '';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
        }
        $coupon = Coupon::create([
            'name'      => $request->input('name'),
            'coupon_code'  => $request->input('coupon_code'),
            'coupon_description'  => $request->input('coupon_description'),
            'discount'  => $request->input('discount'),
            'discount_type'  => $request->input('discount_type'),
            'start_date'  => $request->input('start_date'),
            'expiry_date'  => $request->input('expiry_date'),
            'minimum_order_amount'  => $request->input('minimum_order_amount'),
            'image' => $filename,
        ]);

        return response()->json(['message' => 'Coupon Created successfully', 'coupon' => $coupon], 201);
    }

    public function couponUpdate(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'id' => 'required|exists:coupons,id',
            'name' => 'required',
            'coupon_code' => 'required',
            'discount' => 'required',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'start_date' => 'required',
            'expiry_date' => 'required',
            'minimum_order_amount' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }


        $coupon = Coupon::find($request->input('id'));

        if (is_null($coupon)) {
            return response()->json(['message' => 'Coupon not found'], 404);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
            $coupon->image = $filename;
        }

        $coupon->update([
            'id' => $request->input('id'),
            'name'      => $request->input('name'),
            'coupon_code'  => $request->input('coupon_code'),
            'coupon_description'  => $request->input('coupon_description'),
            'discount'  => $request->input('discount'),
            'discount_type'  => $request->input('discount_type'),
            'start_date'  => $request->input('start_date'),
            'expiry_date'  => $request->input('expiry_date'),
            'minimum_order_amount'  => $request->input('minimum_order_amount'),
        ]);

        return response()->json([
            'message' => 'Coupon updated successfully',
            'cart' => $coupon,
        ], 200);
    }
    public function couponDestroy(Request $request)
    {
        $coupon = Coupon::find($request->input('id'));
        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found'], 404);
        }
        $coupon->delete();
        return response()->json(['message' => 'Coupon deleted successfully']);
    }
}
