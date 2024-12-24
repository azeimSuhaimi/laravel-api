<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\invoice;
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
}
