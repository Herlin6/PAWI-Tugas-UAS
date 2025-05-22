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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->date('borrow_date');
            $table->date('due_date');
            $table->enum('loan_status', ['borrowed', 'returned', 'overdue']);
            $table->date('return_date')->nullable();
            $table->foreignId('member_id')->constrained('members')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('book_id')->constrained('books')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
