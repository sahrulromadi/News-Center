<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function manage()
    {
        $allCategory = Category::all();
        return view('admin.category.manage', compact('allCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:5',
            ]);

            Category::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Successfully saved the data.',
                'redirect_url' => route('admin.category.manage')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                // Lebih baik gunakan name, karena jika menggunakan id, saat di update dengan nama yang sama, maka akan berhasil
                'name' => 'required|string|max:255|unique:category,name,' . $category->name,
            ]);

            $category->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Successfully update the data.',
                'redirect_url' => route('admin.category.manage')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully delete the data.',
                'redirect_url' => route('admin.category.manage')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
