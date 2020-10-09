<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected  $categoryRules = [
        "name" => "string",
        "parent_id" => "required|int"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginatedResult = Category::query()->paginate();
        $headers = [
            'result_page' => $paginatedResult->currentPage(),
            'result_total' => $paginatedResult->total(),
            'result_last_page' => $paginatedResult->lastPage()
        ];

        return response($paginatedResult->items(), 200, $headers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response | Category
     */
    public function store(Request $request)
    {
        try {
            $inputs = $request->validate([
                "name" => "required|string",
                "parent_id" => "int",
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception){
            return response($exception->errors(), 400);
        }

        $category = new Category($inputs);

        //
        $category->save();
        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response | Category
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category  $category
     * @return \Illuminate\Http\Response | Category
     */
    public function update(Request $request, Category $category)
    {
        try {
            $inputs = $request->validate([
                "name" => "required|string",
                "parent_id" => "int",
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception){
            return response($exception->errorBag, 400);
        }

        foreach ($inputs as $key => $value) {
            $category->$key = $value;
        }

        $category->save();
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
}
