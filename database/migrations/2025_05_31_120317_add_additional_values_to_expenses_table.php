<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalValuesToExpensesTable extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->json('additional_values')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('additional_values');
        });
    }
}
