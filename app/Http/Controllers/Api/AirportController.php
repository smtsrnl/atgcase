<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AirportController extends Controller
{
    public function index(Request $request)
    {
        $columns = Schema::getColumnListing('airports'); // users table
        $validator = Validator::make($request->all(), [
            "type" => [
                "required",
                Rule::in(collect($columns)->except(["created_at", "updated_at"])),
            ],
            "searchString" => ["required"],
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors());
        }

        $values = Airport::where($request->type, "like", "%$request->searchString%")->get();

        return $values;
    }
}
