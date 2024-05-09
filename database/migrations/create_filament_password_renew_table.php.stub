<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('filament-authentication.password_renew.table_name'), function (Blueprint $table) {
            $table->id();
            $table->morphs('renewable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('filament-authentication.password_renew.table_name'));
    }
};
