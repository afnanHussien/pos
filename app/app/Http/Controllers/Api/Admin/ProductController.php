<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Product;
use App\Helpers\ImageHelper;
use App\Helpers\VideoHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $producs = Product::latest()->paginate(10);
        return response()->json($producs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = ImageHelper::compress($request->file('image'));
        }

        if ($request->hasFile('video')) {
            $data['video_path'] = VideoHelper::compress($request->file('video'));
        }

        $product = Product::create($data);
        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
