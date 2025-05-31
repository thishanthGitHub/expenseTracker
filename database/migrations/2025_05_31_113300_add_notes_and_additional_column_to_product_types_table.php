<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesAndAdditionalColumnToProductTypesTable extends Migration
{
    public function up()
    {
        Schema::table('product_types', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('name');
            $table->json('additional_column')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('product_types', function (Blueprint $table) {
            $table->dropColumn(['notes', 'additional_column']);
        });
    }
}
