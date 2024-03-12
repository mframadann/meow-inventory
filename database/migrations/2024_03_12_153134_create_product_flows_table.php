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
        Schema::create('product_flows', function (Blueprint $table) {
            $table->uuid("pf_id")->primary()->nullable()->default(Str::uuid());
            $table->enum("type", ["IN", "OUT", "MUTATE"])->default("MUTATE");
            $table->integer("amount")->default(0);
            $table->foreignUuid("product_id")->references("product_id")->on("products")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_flows');
    }
};
