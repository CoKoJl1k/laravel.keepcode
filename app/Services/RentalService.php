<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentalService {


    public function validate(Request $request)
    {
        $input = $request->only('user_id', 'product_id', 'rental_hours');
        $rules = [
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'rental_hours' => 'required|integer',

        ];
        $validator = Validator::make($input, $rules);

        if(!empty($validator->errors()->all())) {
            return ['message' => $validator->errors()->all()[0]];
        }
    }

    public function limitHours(Request $request)
    {
        if ($request->extend_hours > 24){
            return ['message' => 'Rent should not be more than 24 hours'];
        }
    }

}
