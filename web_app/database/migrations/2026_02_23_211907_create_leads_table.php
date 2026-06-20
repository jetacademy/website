<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('school_name');
            $table->string('phone_number');
            $table->enum('status', ['new', 'contacted', 'demo_scheduled', 'closed_won', 'closed_lost'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('leads'); // Mencegah penimpaan data (rules)
    }
};
