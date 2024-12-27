<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\invoice;
use App\Models\user;
use App\Http\Resources\invoiceResource;
use Illuminate\Support\Facades\Storage;

class list_invoiceController extends Controller
{
    public function index()
    {
        $user = user::all();

        //return response()->json(['data' =>$invoice]);

        return invoiceResource::collection($user); //resource untuk colection lebih dari satu row data 
    }

    public function show($id)
    {
        $user = user::findOrFail($id);

        //return response()->json(['data' =>$invoice]);

        return new invoiceResource($user); // resource untuk colection satu row data sahaja

        
    }

    public function store(Request $request)
    {
                // validated new employee data 
                $validated = $request->validate([
            
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|numeric|unique:users,phone',
                    'ic' => 'required|integer|unique:users,ic',
                    'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    
                ]);

                // validate file upload 
                if ($request->hasFile('picture')) 
                {
                    // get upload image to change and validated rule
                    $file = $request->file('picture');
                    $fileName = time().'.'.$file->getClientOriginalExtension();// change name file avoid redundant
            
                    //$file->move(public_path('profile/'), $fileName); // location image store
                    Storage::putFileAs('profile', $file, $fileName);
                    
                    // store image name to database


                    $user = user::add_user($validated['name'],$validated['email'],$validated['phone'],$validated['ic'],$fileName);
                    return response()->json('success upload image');
                }//end validated file

                return $request->picture;
        
                

        return response()->json('fail upload image');
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
