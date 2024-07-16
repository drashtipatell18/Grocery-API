<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesMaster;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;


class SalesMasterController extends Controller
{
    public function salesmaster(){
        $salesmasters = SalesMaster::with(['user', 'coupon', 'userAddress'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Sales master Data successfully',
            'result' => $salesmasters
        ], 200);

    }
    public function salesmasterCreate(){
        $users = User::pluck('name', 'id');
        $coupons = Coupon::pluck('name', 'id');
        $useraddress = UserAddress::pluck('address', 'id');

        return view('salesmaster.create_salesmaster',compact('users','coupons','useraddress'));
    }
    public function salesmasterInsert(Request $request){
        $validateRequest = Validator::make($request->all(), [
            'user_id' => 'required',
            'coupon_id' => 'required',
            'user_address_id' => 'required',
            'order_date' => 'required',
            'sub_total' => 'required',
            'total_amount' => 'required',
            'discount' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $salesmaster = SalesMaster::create([
            'user_id'      => $request->input('user_id'),
            'coupon_id'  => $request->input('coupon_id'),
            'user_address_id'  => $request->input('user_address_id'),
            'order_date'  => $request->input('order_date'),
            'sub_total'  => $request->input('sub_total'),
            'total_amount'  => $request->input('total_amount'),
            'discount'  => $request->input('discount'),
        ]);

        return response()->json(['message' => 'Sales master Created successfully', 'salesmaster' => $salesmaster], 201);
    }

    public function salesmasterUpdate(Request $request, $id){
        $validateRequest = Validator::make($request->all(), [
            'user_id' => 'required',
            'coupon_id' => 'required',
            'user_address_id' => 'required',
            'order_date' => 'required',
            'sub_total' => 'required',
            'total_amount' => 'required',
            'discount' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $salesmaster = SalesMaster::find($id);


        if (is_null($salesmaster)) {
            return response()->json(['message' => 'salesmaster not found'], 404);
        }

        $salesmaster->update([
            'user_id'      => $request->input('user_id'),
            'coupon_id'  => $request->input('coupon_id'),
            'user_address_id'  => $request->input('user_address_id'),
            'order_date'  => $request->input('order_date'),
            'sub_total'  => $request->input('sub_total'),
            'total_amount'  => $request->input('total_amount'),
            'discount'  => $request->input('discount'),
        ]);

        return response()->json([
            'message' => 'Sales Master updated successfully',
            'cart' => $salesmaster,
        ], 200);

    }
    public function salesmasterDestroy($id){
        $salesmaster = SalesMaster::find($id);
        if (!$salesmaster) {
            return response()->json(['message' => 'salesmaster not found'], 404);
        }
        $salesmaster->delete();
        return response()->json(['message' => 'Sales Master deleted successfully']);
    }
}
