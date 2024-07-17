<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
    public function productCreateImage()
    {
        $products = Product::all();
        return view('product_image.create_fileupload', compact('products'));
    }

    public function getProductImage(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $productImageId = ProductImage::find($request->input('id'));

        if ($productImageId) {
            return response()->json([
                'success' => true,
                'data' => $productImageId
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Image not found'
            ], 404);
        }

    }

    public function productInsertImage(Request $request)
    {
        $validateRequest = Validator::make($request->all(), [
            'product_id' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validateRequest->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validateRequest->errors()
            ], 403);
        }

        $product = Product::findOrFail($request->input('product_id'));
        $uploadedImages = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/product_images', $filename);

                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                // $productImage->image = 'storage/product_images/' . $filename;
                $productImage->image = $filename;
                $productImage->save();

                $uploadedImages[] = [
                    'id' => $productImage->id,
                    'image' => $productImage->image,
                    'created_at' => $productImage->created_at,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product Images added successfully!',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
            ],
            'uploaded_images' => $uploadedImages,
        ], 201);

    }
    public function productsImage()
    {
        $productImages = ProductImage::all();
        return response()->json([
            'success' => true,
            'message' => 'Product Image Data successfully',
            'result' => $productImages
        ], 200);

    }


    public function productsImageUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:product_image,id',
            'product_id' => 'required|exists:products,id',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Allow multiple images
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation fails',
                'error' => $validator->errors()
            ], 401);
        }

        $productImage = ProductImage::findOrFail($request->input('id'));

        if (is_null($productImage)) {
            return response()->json(['message' => 'Product Image not found'], 404);
        }
        $product = Product::findOrFail($request->input('product_id'));

        $productImage->product_id = $product->id;
        $uploadedImages = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/product_images', $filename);
                $productImage->image = $filename;
                $productImage->save();

                $uploadedImages[] = [
                    'id' => $productImage->id,
                    'image' => $productImage->image,
                    'created_at' => $productImage->created_at,
                ];
            }
        }
        $productImage->save();


        return response()->json([
            'success' => true,
            'message' => 'Product Images Updated successfully!',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
            ],
            'uploaded_images' => $uploadedImages,
        ], 201);


    }


    public function productsImageDestroy(Request $request)
    {
        $productImages = ProductImage::findOrFail($request->input('id'));
        if (!$productImages) {
            return response()->json(['message' => 'Product Image not found'], 404);
        }
        $productImages->delete();
        return response()->json(['message' => 'Product Image deleted successfully']);

    }



}
