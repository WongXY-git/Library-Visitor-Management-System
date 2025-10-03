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
        Schema::create('sense_visitor_master', function (Blueprint $table) {
            $table->id();
            $table->integer('sense_id');
            $table->string('unique_id', 255)->nullable();
            $table->string('card_no', 255);
            $table->string('name', 255);
            $table->enum('financial_hold', ['Y', 'N'])->default('N');
            $table->string('type', 20)->default('1');
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->dateTime('updated_ts')->nullable();
            $table->dateTime('fr_create_ts')->nullable();
            $table->dateTime('fr_update_ts')->nullable();
            $table->string('status', 30)->nullable();
            $table->string('remarks', 255)->nullable();

            // Indexes for better query performance
            $table->index('sense_id');
            $table->index('unique_id');
            $table->index('card_no');
            $table->index('name');
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sense_visitor_master');
    }
};
