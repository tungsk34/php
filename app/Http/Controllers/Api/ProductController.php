<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json([
                'product' => $product
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'error' => "Product not found"
                ], Response::HTTP_NOT_FOUND);
            }

            return redirect()->json([
                'error' => "Server Error"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $product = Product::findOrFail($id);

            $data['is_active'] ??= 0;

            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('images', $request->file('image'));
            }

            $imageOld = $product->image;

            $product->update($data);

            if (!empty($data['image']) && $imageOld && Storage::exists($imageOld)) {
                Storage::delete($imageOld);
            }

            return response()->json([
                'message' => "Update success",
                'product' => $product
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            if ($data['image'] && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'error' => "Product not found"
                ], Response::HTTP_NOT_FOUND);
            }

            return redirect()->json([
                'error' => "Server Error"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);


            $imageOld = $product->image;

            $product->delete();

            if ($imageOld && Storage::exists($imageOld)) {
                Storage::delete($imageOld);
            }

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'error' => "Product not found"
                ], Response::HTTP_NOT_FOUND);
            }

            return redirect()->json([
                'error' => "Server Error"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
