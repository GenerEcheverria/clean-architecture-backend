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
        Schema::create('texts', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->unsignedInteger('idCol');
            $table->foreign('idCol')->references('id')->on('bodies')->onDelete('cascade');
            $table->string('titleText');
            $table->enum('positionTitle', ['left', 'center', 'right']);
            $table->text('text');
            $table->enum('positionText', ['left', 'center', 'right', 'justified']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};
