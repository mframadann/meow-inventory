<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid("patient_id")->primary()->nullable()->default(Str::uuid());
            $table->date('date_of_birth');
            $table->string('name');
            $table->foreignUuid('owner_id')->references("owner_id")->on('owners')->cascadeOnDelete();
            $table->string('type');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
