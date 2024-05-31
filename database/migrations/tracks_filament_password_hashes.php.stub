<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('filament-authentication.password_renew.table_name'), function (Blueprint $table): void {
            $table->string('phash', 255)->nullable()->after('renewable_id');
        });
    }

};
