<?php

// app/Http/Controllers/ExpenseController.php

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
        if ($request->has('expenseDate')) {
            $request->merge(['expense_date' => $request->input('expenseDate')]);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
            'additional_values' => 'nullable|array',
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

        if ($request->has('expenseDate')) {
            $request->merge(['expense_date' => $request->input('expenseDate')]);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
            'additional_values' => 'nullable|array',
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
