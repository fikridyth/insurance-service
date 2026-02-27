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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
        
            $table->string('claim_number')->unique();
        
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        
            $table->string('title');
            $table->text('description');
        
            $table->decimal('amount', 15, 2);
        
            $table->enum('status', [
                'draft',
                'submitted',
                'verified',
                'approved',
                'rejected'
            ])->default('submitted');
        
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
        
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
        
            $table->text('rejection_reason')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
