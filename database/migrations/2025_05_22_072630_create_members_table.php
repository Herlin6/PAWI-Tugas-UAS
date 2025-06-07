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
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->date('date_of_birth');
            $table->enum('gender', ['M', 'F']);
            $table->string('address', 255);
            $table->string('handphone', 15);
            $table->string('employment', 100)->nullable();
            $table->boolean('borrowing')->default(false);
            $table->string('photo', 50)->nullable();
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
