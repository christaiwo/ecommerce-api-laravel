<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Account\StoreAddressRequest;
use App\Http\Requests\V1\Account\UpdateAddressRequest;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'addresses' => Auth::user()->address,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $data = $request->validated();
        
        $address = Auth::user()->address()->create($data);

        return response()->json(compact('address'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        return response()->json(compact('address'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $data = $request->validated();
        
        $address = $address->update($data);

        return response()->json(compact('address'), 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json([],200);
    }
}
