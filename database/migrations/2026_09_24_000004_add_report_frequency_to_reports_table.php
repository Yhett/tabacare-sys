<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('reports', 'report_frequency')) {
            Schema::table('reports', function (Blueprint $table): void {
                $table->string('report_frequency', 10)->default('monthly')->after('report_period');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('reports', 'report_frequency')) {
            Schema::table('reports', function (Blueprint $table): void {
                $table->dropColumn('report_frequency');
            });
        }
    }
};
