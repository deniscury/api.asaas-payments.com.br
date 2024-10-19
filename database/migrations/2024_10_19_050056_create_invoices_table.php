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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string("billing_type", 20);
            $table->date('due_date');
            $table->integer('installment_count')->nullable();
            $table->decimal("installment_value", 9, 2)->nullable();
            $table->decimal("value", 9, 2);
            $table->string("status", 20);
            $table->string("payment_id", 30)->nullable();
            $table->timestamps();
            
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function(Blueprint $table){
            $table->dropForeign('invoices_client_id_foreign');
        });
        Schema::dropIfExists('invoices');
    }
};
