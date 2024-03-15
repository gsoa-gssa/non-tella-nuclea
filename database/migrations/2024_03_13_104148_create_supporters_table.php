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
        Schema::create('supporters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string("uuid");
            $table->string("email")->unique();
            $table->json("data")->nullable();
            $table->string("email_verification_token")->nullable();
            $table->timestamp("email_verified_at")->nullable();
            $table->boolean("public")->default(false);
            $table->string("configuration")->default("DEFAULT");
            $table->foreign("configuration")->references("key")->on("configurations")->onDelete("cascade");
            $table->boolean("optin")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supporters');
    }
};
