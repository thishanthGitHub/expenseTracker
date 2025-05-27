<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        return Expense::with(['product.productType'])
            ->where('user_id', Auth::id())
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discounted_price' => 'nullable|numeric',
            'date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();

        return Expense::create($validated);
    }

    public function show(Expense $expense)
    {
        $this->authorize('view', $expense);

        return $expense->load(['product.productType']);
    }

    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discounted_price' => 'nullable|numeric',
            'date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $expense->update($validated);

        return $expense;
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);

        $expense->delete();

        return response()->noContent();
    }
}
