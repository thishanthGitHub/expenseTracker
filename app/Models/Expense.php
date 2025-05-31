<?php

// app/Models/Expense.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'discounted_price',
        'price',
        'notes',
        'expense_date'
    ];

    protected $casts = [
        'additional_values' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
