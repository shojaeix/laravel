<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductExpirationController extends Controller
{
    // return products with closer expiration date
    public function closest(Request $request){
        try {
            $request->validate(['max_days_until_expiration' => 'int|min:0']);
        } catch (ValidationException $exception) {
            return response($exception->errorBag, 400);
        }

        $maxExpirationDate = now()->addDays($request->get('max_days_until_expiration'));

        $paginatedResult = Product::query()
            ->where("expire_date", ">", now())
            ->where('expire_date', '<=', $maxExpirationDate)
            ->orderBy("expire_date")
            ->paginate();

        $headers = [
            'result_page' => $paginatedResult->currentPage(),
            'result_total' => $paginatedResult->total(),
            'result_last_page' => $paginatedResult->lastPage()
        ];

        return response($paginatedResult->items(), 200, $headers);
    }
}
