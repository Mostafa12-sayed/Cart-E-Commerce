<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        try{
            ContactUs::create($request->all());

            return response()->json([
                "success"=>true,
                "message"=>"Message sent successfully"
            ]);
        }catch (\Exception $exception){
            return response()->json([
                "success"=>false,
                "message"=>$exception->getMessage()
            ]);
        }

    }
}
