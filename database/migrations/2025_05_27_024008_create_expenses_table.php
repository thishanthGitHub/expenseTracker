<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->date('expense_date'); // Custom date for the expense
            $table->timestamps();         // Adds created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
