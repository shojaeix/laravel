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
     * @return array
     */
    public function index()
    {
        return Product::query()->paginate()->items();
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
                "produced_at" => "int",
                "expire_date" => "int"
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception){
            return response($exception->getMessage(), 400);
        }

        $product = new Product($inputs);

        // set dates
        if(isset($inputs['produced_at'])) {
            $product->produced_at = Carbon::createFromTimestamp($inputs['produced_at'], new \DateTimeZone("UTC"));
            unset($inputs['produced_at']);
        }

        if(isset($inputs['expire_date'])) {
            $product->expire_date = Carbon::createFromTimestamp($inputs['expire_date'], new \DateTimeZone("UTC"));
            unset($inputs['expire_date']);
        }

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
                "produced_at" => "int",
                "expire_date" => "int"
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception){
            return response($exception->getMessage(), 400);
        }

        // set dates
        if(isset($inputs['produced_at'])) {
            $product->produced_at = Carbon::createFromTimestamp($inputs['produced_at'], new \DateTimeZone("UTC"));
            unset($inputs['produced_at']);
        }

        if(isset($inputs['expire_date'])) {
            $product->expire_date = Carbon::createFromTimestamp($inputs['expire_date'], new \DateTimeZone("UTC"));
            unset($inputs['expire_date']);
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
