<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();

        return response()->json([
            'customers' => $customers
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $customer = Customer::create($this->validationRequest());

        $this->storeImage($customer);

        return response()->json([
            'customer' => $customer
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'customer' => $customer
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $this->deleteFile($customer);

        $customer->update($this->validationRequest());

        $this->storeImage($customer);

        return response()->json([
            'customer' => $customer
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if ($customer->image !== 'image/user.png') {
            Storage::delete('public/'.$customer->image);
        }

        $customer->delete();


        return response()->json([
            'customer' => $customer
        ], 200);
    }

    public function validationRequest()
    {
        return request()->validate([
            'name' => 'required|min:3',
            'gender' => 'required',
            'type' => 'required',
            'email' => 'sometimes|nullable|email',
            'phone' => 'sometimes|nullable',
            'website' => 'sometimes|nullable|url',
            'image' => 'sometimes|max:2048',
        ]);
    }

    public function storeImage($customer)
    {
        if (request()->hasFile('image')) {
            $customer->update([
                'image' => request()->image->store('uploads/customers', 'public'),
            ]);

            // $image = Image::make(public_path('storage/' .$customer->image))->fit(300, 300, null, 'top')->save();
        }

        return;
    }

    public function deleteFile($customer)
    {
        if ($customer->image == 'image/user.png') {
            return;
        }

        if (request()->hasFile('image') && Storage::exists('public/'.$customer->image)) {
            Storage::delete('public/'.$customer->image);
        }

    }

}
