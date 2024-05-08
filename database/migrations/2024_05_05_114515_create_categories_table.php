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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->json('name');
            $table->string('slug');
            $table->json('description')->nullable()->default(null);
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('parent_id', 'self_categories_parent_id_foreign')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('admin_id', 'categories_admin_id_foreign')->references('id')->on('admins')->cascadeOnDelete();
            $table->unique(['slug', 'admin_id','parent_id'], 'categories_slug_admin_id_parent_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
