<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductService {


    public function validate(Request $request)
    {
        $input = $request->only('name', 'amount', 'price', 'is_rentable', 'status');
        $rules = [
            'name' => 'required|max:255',
            'amount' => 'required|integer',
            'price' => 'required|numeric|max:99999.99',
            'is_rentable' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($input, $rules);

        if(!empty($validator->errors()->all())) {
            return ['message' => $validator->errors()->all()[0]];
        }
    }
}
