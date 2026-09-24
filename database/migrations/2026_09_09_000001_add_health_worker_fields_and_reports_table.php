<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable();
            }

            if (! Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->unique();
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('health_worker')->after('password');
            }

            if (! Schema::hasColumn('users', 'barangay')) {
                $table->string('barangay', 100)->nullable()->after('role');
            }

            if (! Schema::hasColumn('users', 'last_active')) {
                $table->timestamp('last_active')->nullable();
            }

            if (! Schema::hasColumn('users', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        if (! Schema::hasTable('reports')) {
            Schema::create('reports', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('worker_id')->constrained('users')->cascadeOnDelete();
                $table->string('barangay', 100);
                $table->text('diseases');
                $table->unsignedInteger('patient_count')->default(0);
                $table->string('prepared_by', 150)->nullable();
                $table->string('attachment_path')->nullable();
                $table->string('attachment_name')->nullable();
                $table->timestamp('submitted_at')->useCurrent();
            });
        } else {
            Schema::table('reports', function (Blueprint $table): void {
                if (! Schema::hasColumn('reports', 'prepared_by')) {
                    $table->string('prepared_by', 150)->nullable()->after('patient_count');
                }

                if (! Schema::hasColumn('reports', 'attachment_path')) {
                    $table->string('attachment_path')->nullable()->after('prepared_by');
                }

                if (! Schema::hasColumn('reports', 'attachment_name')) {
                    $table->string('attachment_name')->nullable()->after('attachment_path');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');

        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }

            foreach (['last_active', 'barangay', 'role'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
