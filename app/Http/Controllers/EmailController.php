<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
class EmailController extends Controller
{
    //
    public function store(Request $request) {
        Log::debug($request);
        return response()->json(['message' => 'Successfully received the record'], 200);
    }
}
