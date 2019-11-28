<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();

        return response()->json([
            'products' => $products
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
    public function store(CreateProductRequest $request)
    {
        $product = Product::create($request->all());

        $this->storeImage($product);

        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        $this->deleteFile($product);


        $this->storeImage($product);

        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->image !== 'image/book.png') {
            Storage::delete('public/'.$product->image);
        }

        $product->delete();

        return response()->json([
            'product' => $product
        ], 200);
    }

    public function storeImage($product)
    {
        if (request()->hasFile('image')) {
            $product->update([
                'image' => request()->image->store('uploads/products', 'public'),
            ]);

            // $image = Image::make(public_path('storage/' .$product->image))->fit(300, 300, null, 'top')->save();
        }

        return;
    }

    public function deleteFile($product)
    {
        if ($product->image == 'image/book.png') {
            return;
        }

        if (request()->hasFile('image') && Storage::exists('public/'.$product->image)) {
            Storage::delete('public/'.$product->image);
        }

    }

    public function addstock(Product $product)
    {
        $product->increment('stock', request()->addstock);

        return response()->json([
            'product' => $product->fresh()
        ], 200);
    }
}
