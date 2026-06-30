<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->boolean('has_toilet')->default(false)->after('status');
            $table->boolean('has_musholla')->default(false)->after('has_toilet');
            $table->boolean('has_wifi')->default(false)->after('has_musholla');
            $table->boolean('has_camping')->default(false)->after('has_wifi');
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['has_toilet', 'has_musholla', 'has_wifi', 'has_camping']);
        });
    }
};
