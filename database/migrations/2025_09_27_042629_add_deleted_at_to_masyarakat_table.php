<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            // Tambahkan kolom deleted_at jika belum ada
            if (!Schema::hasColumn('masyarakat', 'deleted_at')) {
                $table->softDeletes(); // Ini akan menambah kolom deleted_at
            }
        });
    }

    public function down()
    {
        Schema::table('masyarakat', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Hapus kolom deleted_at
        });
    }
};