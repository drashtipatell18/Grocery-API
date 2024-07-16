<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesDetails;
use App\Models\SalesMaster;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class SalesDetailsController extends Controller
{
    public function salesdetail()
    {
        $salesdetails = SalesDetails::with(['salesMaster', 'product'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Sales Detail Data successfully',
            'result' => $salesdetails
        ], 200);
    }

    public function salesdetailCreate()
    {
        $salesmasters = SalesMaster::pluck('id', 'id');
        $products = Product::pluck('name', 'id');
        return view('salesdetail.create_salesdetail', compact('salesmasters', 'products'));
    }
    public function salesdetailInsert(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'sales_master_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
            'discount' => 'required',
            'total_amount' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $salesdetails = SalesDetails::create([
            'sales_master_id'  => $request->input('sales_master_id'),
            'product_id'       => $request->input('product_id'),
            'quantity'  => $request->input('quantity'),
            'amount'  => $request->input('amount'),
            'discount'  => $request->input('discount'),
            'total_amount'  => $request->input('total_amount'),
        ]);

        return response()->json(['message' => 'Sales details Created successfully', 'salesdetails' => $salesdetails], 201);
    }

    public function salesdetailUpdate(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'id' => 'required|exists:sales_details,id',
            'sales_master_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
            'discount' => 'required',
            'total_amount' => 'required',
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $salesdetails = SalesDetails::find($request->input('id'));

        if (is_null($salesdetails)) {
            return response()->json(['message' => 'Salesdetails not found'], 404);
        }


        $salesdetails->update([
            'id' => $request->input('id'),
            'sales_master_id'  => $request->input('sales_master_id'),
            'product_id'       => $request->input('product_id'),
            'quantity'  => $request->input('quantity'),
            'amount'  => $request->input('amount'),
            'discount'  => $request->input('discount'),
            'total_amount'  => $request->input('total_amount'),
        ]);

        return response()->json([
            'message' => 'Sales Detail updated successfully',
            'cart' => $salesdetails,
        ], 200);
    }
    public function salesdetailDestroy(Request $request)
    {
        $salesdetails = SalesDetails::find($request->input('id'));
        if (!$salesdetails) {
            return response()->json(['message' => 'Sales Detail not found'], 404);
        }
        $salesdetails->delete();
        return response()->json(['message' => 'Sales Detail deleted successfully']);
    }
}
