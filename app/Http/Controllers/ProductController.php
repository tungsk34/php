<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const VIEW_PATH = 'products.';
    public function index()
    {
        $products = Product::query()->latest('id')->paginate(1);
        return view(self::VIEW_PATH . __FUNCTION__, compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::VIEW_PATH . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        try {

            $data['is_active'] ??= 0;

            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('images', $request->file('image'));
            }

            Product::create($data);

            return redirect()->route('products.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());


            if ($data['image'] && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
