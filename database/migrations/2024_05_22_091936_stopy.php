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
        Schema::create('stopy', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->float('ref')->nullable();
            $table->float('lom')->nullable();
            $table->float('dep')->nullable();
            $table->float('red')->nullable();
            $table->float('dys')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
