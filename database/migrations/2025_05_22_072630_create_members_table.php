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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_number', 15)->unique();
            $table->date('date_of_birth');
            $table->enum('gender', ['M', 'F']);
            $table->string('address', 255);
            $table->string('handphone', 15);
            $table->string('employment', 100)->nullable();
            $table->boolean('borrowing')->default(false);
            $table->string('photo', 100)->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
