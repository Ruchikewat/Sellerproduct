<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();  // bigIncrements implicitly
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('country');
            $table->string('state');
            $table->string('password');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sellers');
    }
};
