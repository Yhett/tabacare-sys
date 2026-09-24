<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table): void {
                if (! Schema::hasColumn('patients', 'age')) {
                    $table->unsignedTinyInteger('age')->nullable();
                }

                if (! Schema::hasColumn('patients', 'gender')) {
                    $table->string('gender', 20)->nullable();
                }

                if (! Schema::hasColumn('patients', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
            });

            return;
        }

        Schema::create('patients', function (Blueprint $table): void {
            $table->id();
            $table->string('patient_code')->unique();
            $table->string('disease');
            $table->date('date_onset');
            $table->string('address', 100);
            $table->unsignedTinyInteger('age');
            $table->string('gender', 20);
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['address', 'disease']);
            $table->index(['address', 'date_onset']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
