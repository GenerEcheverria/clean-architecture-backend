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
        Schema::create('footers', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->unsignedInteger('idSite');
            $table->foreign('idSite')->references('id')->on('sites')->onDelete('cascade');
            $table->string('backgroundColor');
            $table->string('textColor');
            $table->boolean('setSocialMedia');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('otro')->nullable();
            $table->boolean('setContact');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->boolean('setExtra');
            $table->string('text')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->unique('idSite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
