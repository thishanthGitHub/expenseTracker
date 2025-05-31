<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = ['name', 'notes', 'additional_column'];
    protected $casts = [
        'additional_column' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
