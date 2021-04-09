<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->index();
            $table->string('thumbnail');
            $table->boolean('has_certificate');
            $table->enum('type', ['free', 'premium'])->index();
            $table->enum('status', ['draft', 'published', 'inactive'])->index();
            $table->decimal('price')->default(0)->nullable()->index();
            $table->enum('level', ['all-level', 'beginner', 'intermediate', 'advanced'])->index();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
