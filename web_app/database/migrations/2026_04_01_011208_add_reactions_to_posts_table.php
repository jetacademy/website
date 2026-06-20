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
        Schema::table('posts', function (Blueprint $col) {
            $col->unsignedInteger('count_suka')->default(0);
            $col->unsignedInteger('count_tertawa')->default(0);
            $col->unsignedInteger('count_sedih')->default(0);
            $col->unsignedInteger('count_marah')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $col) {
            $col->dropColumn(['count_suka', 'count_tertawa', 'count_sedih', 'count_marah']);
        });
    }
};
