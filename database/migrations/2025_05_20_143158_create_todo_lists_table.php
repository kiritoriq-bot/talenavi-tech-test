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
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('assignee')->nullable();
            $table->date('due_date');
            $table->decimal('time_tracked')->default(0);
            $table->enum('status', \App\Enums\Status::getValues())->default(\App\Enums\Status::Pending->value);
            $table->enum('priority', \App\Enums\Priority::getValues());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_lists');
    }
};
