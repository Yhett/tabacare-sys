<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reports') && ! Schema::hasColumn('reports', 'report_period')) {
            Schema::table('reports', function (Blueprint $table): void {
                $table->date('report_period')->nullable()->after('barangay');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('reports') && Schema::hasColumn('reports', 'report_period')) {
            Schema::table('reports', function (Blueprint $table): void {
                $table->dropColumn('report_period');
            });
        }
    }
};
