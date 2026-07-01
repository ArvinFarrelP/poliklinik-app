<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('detail_periksa', function (Blueprint $table) {
        $table->integer('jumlah')->default(1)->after('id_obat');
    });
}

public function down(): void
{
    Schema::table('detail_periksa', function (Blueprint $table) {
        $table->dropColumn('jumlah');
    });
}
};