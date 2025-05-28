<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return Product::with('productType')->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'name' => 'required|string',
        ]);
        return Product::create($validated);
    }

    public function show(Product $product) {
        return $product->load('productType');
    }

    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'name' => 'required|string',
        ]);
        $product->update($validated);
        return $product;
    }

    public function destroy(Product $product) {
        $product->delete();
        return response()->noContent();
    }
}
