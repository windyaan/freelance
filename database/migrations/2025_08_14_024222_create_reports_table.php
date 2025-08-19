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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); // user yg melapor
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade'); // freelancer yg dilaporkan
            $table->string('title'); // judul laporan
            $table->text('description'); // detail laporan
            $table->enum('status', ['Dalam Proses', 'Ditolak', 'Selesai'])->default('Dalam Proses'); // status laporan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
