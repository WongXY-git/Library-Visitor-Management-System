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
            $table->string('sense_id')->nullable();
            $table->string('unique_id', 10)->nullable();
            $table->string('card_no');
            $table->string('name');
            $table->string('photo_path')->nullable();
            $table->char('active', 1)->default('Y');
            $table->string('status', 30)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('updated_ts')->nullable();
            $table->timestamp('fr_create_ts')->nullable();
            $table->timestamp('fr_update_ts')->nullable();

            // Indexes for better query performance
            $table->index('sense_id');
            $table->index('unique_id');
            $table->index('card_no');
            $table->index('name');
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
