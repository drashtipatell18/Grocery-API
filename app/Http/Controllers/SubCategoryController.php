<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function subcategory(){
        $subcategorys = SubCategory::with('category')->get();

        return response()->json([
            'success' => true,
            'message' => 'Sub Category Data successfully',
            'result' => $subcategorys
        ], 200);
    }

    public function getSubCategory(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $subcategorys = SubCategory::find($request->input('id'));

        if ($subcategorys) {
            return response()->json([
                'success' => true,
                'data' => $subcategorys
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sub Category not found'
            ], 404);
        }

    }

    public function createsubCategory(){
        $categorys = Category::all();
        return view('subcategory.create_sub_category',compact('categorys'));
    }
    public function storesubCategory(Request $request) {
        $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required',
        ]);

        $filename = '';

        if ($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
        }

        $subcategory = SubCategory::create([
            'category_id'      => $request->input('category_id'),
            'subcategory_name' => $request->input('subcategory_name'),
            'image'            => $filename,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sub Category inserted successfully.',
            'data' => $subcategory
        ], 201);
    }


    public function Updatesubcategory(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sub_categories,id',
            'category_id' => 'required',
            'subcategory_name' => 'required',
        ]);

        $subcategory = SubCategory::find($request->input('id'));

        if (!$subcategory) {
            return response()->json(['error' => 'Sub Category not found'], 404);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
            $subcategory->image = $filename;
        }
        $subcategory->update([
            'id' => $request->input('id'),
            'category_id' => $request->input('category_id'),
            'subcategory_name' => $request->input('subcategory_name'),
        ]);
        return response()->json(['success' => 'Sub Category updated successfully.', 'category' => $subcategory], 200);

    }
    public function Destroysubcategory(Request $request)
    {
        $subcategory = SubCategory::find($request->input('id'));
        if (!$subcategory) {
            return response()->json(['message' => 'Sub Category not found'], 404);
        }
        $subcategory->delete();
        return response()->json(['message' => 'Sub Category deleted successfully']);

    }
}
