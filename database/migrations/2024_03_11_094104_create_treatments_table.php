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

        Schema::create('treatments', function (Blueprint $table) {
            $table->uuid("treatment_id")->primary()->nullable()->default(Str::uuid());
            $table->string('description');
            $table->text('notes')->nullable();
            $table->foreignUuid('patient_id')->references("patient_id")->on('patients')->cascadeOnDelete();
            $table->unsignedInteger('price')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
