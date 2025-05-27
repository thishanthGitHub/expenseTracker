<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create users table if it doesn't exist
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
                $table->boolean('active')->default(true);
                $table->softDeletes();

                // Add missing columns now
                $table->string('nic_no')->nullable();
                $table->string('phone_number')->nullable();
            });
        } else {
            // Add missing columns if they don't exist
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'active')) {
                    $table->boolean('active')->default(true);
                }
                if (!Schema::hasColumn('users', 'deleted_at')) {
                    $table->softDeletes();
                }
                if (!Schema::hasColumn('users', 'nic_no')) {
                    $table->string('nic_no')->nullable();
                }
                if (!Schema::hasColumn('users', 'phone_number')) {
                    $table->string('phone_number')->nullable();
                }
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'active')) {
                $table->dropColumn('active');
            }
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            if (Schema::hasColumn('users', 'nic_no')) {
                $table->dropColumn('nic_no');
            }
            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });
    }
};
