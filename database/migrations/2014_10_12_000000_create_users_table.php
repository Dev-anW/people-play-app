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
    Schema::create('users', function (Blueprint $table) {
        // Standard Laravel fields
        $table->id();

        // --- Your 8 Required Data Fields ---

        // Field 1: Name
        $table->string('name');

        // Field 2: Surname
        $table->string('surname');

        // Field 3: South African ID Number
        // A string is used to preserve leading zeros and is safer than an integer.
        // unique() ensures no two users can have the same ID number.
        $table->string('sa_id_number')->unique();

        // Field 4: Mobile Number
        // nullable() makes this field optional.
        $table->string('mobile_number')->nullable();

        // Field 5: Email Address
        // This will be used for login and notifications.
        $table->string('email')->unique();

        // Field 6: Birth Date
        // The 'date' type is specifically for storing dates without time.
        $table->date('birth_date')->nullable();

        // Field 7: Language (Single Selection)
        // A simple string field. For more complex apps, this could be a
        // foreign key to a 'languages' table.
        $table->string('language');

        // Field 8 (Interests) is handled in a separate table below.

        // --- System & Security Fields ---

        // Field 9: Email Verification
        // This timestamp is null until the user clicks the verification link.
        $table->timestamp('email_verified_at')->nullable();

        // For the admin's login password.
        $table->string('password');

        // Determines if a user is an admin. Defaults to false.
        $table->boolean('is_admin')->default(false);

        // Standard Laravel fields for security and timestamps.
        $table->rememberToken();
        $table->timestamps(); // Adds created_at and updated_at columns
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
