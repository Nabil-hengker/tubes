<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable();
        $table->string('nim')->nullable();
        $table->string('major')->nullable();
        $table->string('university')->nullable();
        $table->text('bio')->nullable();
    });
}

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            foreach (['phone', 'nim', 'major', 'university', 'bio'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $columns[] = $column;
                }
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
