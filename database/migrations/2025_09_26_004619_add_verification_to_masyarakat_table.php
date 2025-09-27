<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->boolean('terverifikasi')->default(false)->after('alamat');
            $table->timestamp('verified_at')->nullable()->after('terverifikasi');
            $table->foreignId('verified_by')->nullable()->constrained('administrator')->after('verified_at');
        });
    }

    public function down()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->dropColumn(['terverifikasi', 'verified_at', 'verified_by']);
        });
    }
};