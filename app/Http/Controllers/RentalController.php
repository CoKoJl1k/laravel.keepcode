<?php

namespace App\Http\Controllers;

use App\Events\ProductPurchased;
use App\Models\Product;
use App\Models\Rental;
use App\Services\RentalService;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    private RentalService $rentalService;

    public function __construct(RentalService $rentalService)
    {
        $this->rentalService = $rentalService;
    }


    public function rent(Request $request)
    {

        $product = Product::where('status', 'available')->where('amount', '>', 0)->find($request->product_id);

        if (empty($product)){
            return response()->json(['message' => 'Product not available.'],400);
        }

        if (!$product->is_rentable) {
            return response()->json(['error' => 'This product is not available for rental.'], 400);
        }

        $limitError = $this->rentalService->limitHours($request);
        if(!empty($limitError['message'])) {
            return response()->json(['error' => $limitError['message']], 400);
        }

        $errors = $this->rentalService->validate($request);
        if(!empty($errors['message'])) {
            return response()->json(['message' => $errors['message']],400);
        }

        $rental = new Rental();
        $rental->user_id = $request->user_id;
        $rental->product_id = $product->id;
        $expiryDate = now()->addHours($request->rental_hours);
        $expiryDateFormat = $expiryDate->format('Y-m-d H:i:s');
        $rental->expiry_date = $expiryDateFormat;
        $rental->save();

        event(new ProductPurchased($product, 1));

        return response()->json(['message' => 'Rental created successfully.', 'expiry_date' => $expiryDateFormat]);
    }

    public function extend(Request $request, Rental $rental)
    {
        if ($rental->isExpired()) {
            return response()->json(['error' => 'Cannot extend expired rental.'], 400);
        }
        if (empty($request->extend_hours)) {
            return response()->json(['error' => "Variable 'extend_hours' is empty !"], 400);
        }
        $limitError = $this->rentalService->limitHours($request);
        if(!empty($limitError['message'])) {
            return response()->json(['error' => $limitError['message']], 400);
        }

        $hours = $request->extend_hours;
        $rental->extendRental($hours);
        $new_expiry_date = $rental->expiry_date->format('Y-m-d H:i:s');



        return response()->json(['message' => 'Rental extended successfully.', 'new_expiry_date' => $new_expiry_date]);
    }

}
