<?php
namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index() {
        return ProductType::all();
    }

    public function store(Request $request) {
        $validated = $request->validate(['name' => 'required|string|unique:product_types']);
        return ProductType::create($validated);
    }

    public function show(ProductType $productType) {
        return $productType;
    }

    public function update(Request $request, ProductType $productType) {
        $validated = $request->validate(['name' => 'required|string|unique:product_types,name,' . $productType->id]);
        $productType->update($validated);
        return $productType;
    }

    public function destroy(ProductType $productType) {
        $productType->delete();
        return response()->noContent();
    }
}
