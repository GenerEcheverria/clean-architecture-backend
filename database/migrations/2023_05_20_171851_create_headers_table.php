<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('headers', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->unsignedInteger('idSite');
            $table->foreign('idSite')->references('id')->on('sites')->onDelete('cascade');
            $table->string('title');
            $table->enum('size', ['medium', 'small', 'big']);
            $table->enum('position', ['left', 'right', 'center']);
            $table->string('color');
            $table->string('image')->nullable();
            $table->boolean('hero');
            $table->timestamps();

            $table->unique('idSite');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('headers');
    }
};
