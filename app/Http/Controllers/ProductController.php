<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function productCreate()
    {
        $categorys = Category::all();
        $sub_categorys = SubCategory::all();
        return view('products.create_products',compact('categorys','sub_categorys'));
    }

    public function getProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $productId = Product::find($request->input('id'));

        if ($productId) {
            return response()->json([
                'success' => true,
                'data' => $productId
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

    }


    public function productInsert(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ]);


        return response()->json(['message' => 'Product Add successfully', 'product' => $product], 201);
    }
    public function products()
    {
        $products = Product::with('category', 'subcategory')->get();
        return response()->json([
            'success' => true,
            'message' => 'Product Data successfully',
            'result' => $products
        ], 200);
    }

    public function productUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
            'name' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation fails',
                'error' => $validator->errors()
            ], 401);
        }

        $products = Product::find($request->input('id'));

        if (is_null($products)) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $products->update([
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ]);


        return response()->json([
            'message' => 'Product updated successfully',
            'user' => $products,
        ], 200);

    }
    public function productDestroy(Request $request)
    {
        $product = Product::find($request->input('id'));
        if (!$product) {
            return response()->json(['message' => 'Products not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);

    }

}
