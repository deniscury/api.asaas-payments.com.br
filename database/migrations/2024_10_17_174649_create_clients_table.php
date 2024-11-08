<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', 
            function (Blueprint $table) {
                $table->id();
                $table->string("name", 100);
                $table->string("document", 14)->unique();
                $table->string("email", 200)->unique();
                $table->string("phone", 40)->unique();
                $table->string("postal_code", 8);
                $table->string("address", 200);
                $table->string("address_number", 8);
                $table->string("customer_id", 30)->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
