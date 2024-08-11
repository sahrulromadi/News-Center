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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('status')->default('Pending');
            $table->foreignId('user_id')->constrained(
                table: 'users',
                indexName: 'news_user_id'
            );
            $table->foreignId('category_id')->constrained(
                table: 'category',
                indexName: 'news_category_id'
            );
            $table->unsignedBigInteger('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
