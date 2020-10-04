<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|\Illuminate\Http\Response
     */
    public function index()
    {
        $paginatedResult = Product::query()->paginate();
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
     * @return \Illuminate\Http\Response|Product
     */
    public function store(Request $request)
    {

        try {
            $inputs = $request->validate([
                "name" => "string",
                "price" => "required|int",
                "photo" => "string",
                "barcode_number" => "string",
                "produced_at" => "date",
                "expire_date" => "date"
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception){
            return response($exception->errorBag, 400);
        }

        $product = new Product($inputs);

        //
        $product->save();
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response | Product
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response | Product
     */
    public function update(Request $request, Product $product)
    {
        try {
            $inputs = request()->validate([
                "name" => "string",
                "price" => "required|int",
                "photo" => "string",
                "barcode_number" => "string",
                "produced_at" => "date",
                "expire_date" => "date"
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception){
            return response($exception->errorBag, 400);
        }

        foreach ($inputs as $key => $value) {
            $product->$key = $value;
        }

        $product->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
