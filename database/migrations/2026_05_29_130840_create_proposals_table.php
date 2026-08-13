<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('division');
            $table->string('category');
            $table->date('event_date');
            $table->bigInteger('budget');
            $table->text('description');
            $table->string('document');
            // Status awal otomatis 'pending_bph'
            $table->string('status')->default('pending_bph'); 
            $table->text('notes')->nullable(); // Untuk menyimpan catatan revisi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};