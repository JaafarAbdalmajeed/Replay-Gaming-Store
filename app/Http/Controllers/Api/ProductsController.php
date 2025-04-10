<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Response;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }
    /**
     * Display a listing of the products with filters and pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $products = Product::filter($request->query())
            ->with('category:id,name', 'store:id,name', 'tags:id,name')
            ->paginate();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'status'        => 'in:active,inactive',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);
        $user = $request->user();
        if (!$user->tokenCan('products.create')) {
            abort(403, 'Not allowed');
        }

        $product = Product::create($validated);

        return Response::json($product, 201, [
            'Location' => route('products.show', $product->id)
        ]);
    }

    /**
     * Display the specified product with its relations.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
        $product->load('category:id,name', 'store:id,name', 'tags:id,name');

        return response()->json($product);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        // sometimes
        $validated = $request->validate([
            'name'          => 'sometimes|required|string|max:255',
            'description'   => 'nullable|string|max:255',
            'category_id'   => 'sometimes|required|exists:categories,id',
            'status'        => 'in:active,inactive',
            'price'         => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);
        $user = $request->user();
        if (!$user->tokenCan('products.update')) {
            abort(403, 'Not allowed');
        }


        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user->tokenCan('products.delete')) {
            return response([
                'message' => 'Not Allowed'
            ], 403);
        }

        Product::destroy($id);

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
