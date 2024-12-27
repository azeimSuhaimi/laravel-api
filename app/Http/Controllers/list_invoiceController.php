<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\invoice;
use App\Models\user;
use App\Http\Resources\invoiceResource;

class list_invoiceController extends Controller
{
    public function index()
    {
        $invoice = invoice::all();

        //return response()->json(['data' =>$invoice]);

        return invoiceResource::collection($invoice); //resource untuk colection lebih dari satu row data 
    }

    public function show($id)
    {
        $invoice = invoice::findOrFail($id);

        //return response()->json(['data' =>$invoice]);

        return new invoiceResource($invoice); // resource untuk colection satu row data sahaja

        
    }

    public function store(Request $request)
    {
                // validated new employee data 
                $validated = $request->validate([
            
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|numeric|unique:users,phone',
                    'ic' => 'required|integer|unique:users,ic',
                    
                ]);
        
                $user = user::add_user($validated['name'],$validated['email'],$validated['phone'],$validated['ic']);

        return response()->json('$data, 200, $headers');
    }

    public function update(Request $request,$id)
    {
        // validated new employee data 
        $validated = $request->validate([

            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'ic' => 'required',
            
        ]); 

        $user = user::update_last_login($validated['email']);

        dd('ini update');
    }

    public function destroy($id)
    {
        $user = user::find($id);
        if(!$user)
        {
            return 'tiada data '.$id ;
        }
        $user->delete();

        return response()->json('ini delete');
    }
}
