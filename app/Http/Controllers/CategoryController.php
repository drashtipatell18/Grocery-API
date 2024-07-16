<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {
        $categorys = Category::all();

        return response()->json([
            'success' => true,
            'message' => 'Category Data successfully',
            'result' => $categorys
        ], 200);
    }
    public function createCategory()
    {
        return view('category.create_category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $filename = '';

        if ($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
        }

        $category  = Category::create([
            'category_name' => $request->input('category_name'),
            'image'         => $filename,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category inserted successfully.',
            'data' => $category
        ], 201);

    }

    public function categoryUpdate(Request $request)
    {
        $request->validate([
           'id' => 'required|exists:categories,id',
            'category_name' => 'required|string|max:255',
        ]);

        $category = Category::find($request->input('id'));

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
            $category->image = $filename;
        }

        // Update category name
        $category->update([
            'id' => $request->input('id'),
            'category_name' => $request->input('category_name')
        ]);

        return response()->json(['success' => 'Category updated successfully.', 'category' => $category], 200);


    }

    public function categoryDestroy(Request $request)
    {
        $category = Category::find($request->input('id'));
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);

    }

}
