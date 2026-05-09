<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('hash' ,32)->index();
            $table->boolean('is_duplicate')->nullable()->index();
            $table->foreignId('import_job_id')->nullable()->constrained('import_jobs');
            $table->foreignId('duplicate_group_id')->nullable()->constrained('duplicate_groups');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
