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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->char('book_number', 10);
            $table->string('title', 100);
            $table->string('author', 50);
            $table->string('publisher', 50);
            $table->string('isbn', 13);
            $table->string('genre', 30);
            $table->date('publish_date');
            $table->text('synopsis');
            $table->boolean('availability')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
