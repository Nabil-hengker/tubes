<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('scholarships')) {
            Schema::table('scholarships', function (Blueprint $table) {
                if (! Schema::hasColumn('scholarships', 'description')) {
                    $table->text('description')->nullable();
                }
                if (! Schema::hasColumn('scholarships', 'country')) {
                    $table->string('country')->nullable();
                }
                if (! Schema::hasColumn('scholarships', 'status')) {
                    $table->string('status')->default('open');
                }
            });
        }

        if (Schema::hasTable('applications')) {
            Schema::table('applications', function (Blueprint $table) {
                if (! Schema::hasColumn('applications', 'npm')) {
                    $table->string('npm')->nullable();
                }
                if (! Schema::hasColumn('applications', 'nama_lengkap')) {
                    $table->string('nama_lengkap')->nullable();
                }
                if (! Schema::hasColumn('applications', 'ipk')) {
                    $table->decimal('ipk', 3, 2)->nullable();
                }
                if (! Schema::hasColumn('applications', 'penghasilan_orang_tua')) {
                    $table->decimal('penghasilan_orang_tua', 15, 2)->nullable();
                }
                if (! Schema::hasColumn('applications', 'catatan_admin')) {
                    $table->text('catatan_admin')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        //
    }
};
