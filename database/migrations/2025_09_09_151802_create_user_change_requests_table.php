<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('user_change_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->json('requested_data'); // Stores the changes the user wants
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->foreignId('reviewed_by')->nullable()->constrained('users'); // The admin who reviewed it
        $table->timestamp('reviewed_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_change_requests');
    }
};
