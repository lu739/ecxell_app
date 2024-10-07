<?php

use App\Models\Type;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Type::class);
            $table->string('title');
            $table->date('date_created');
            $table->boolean('is_chain')->nullable();
            $table->unsignedInteger('worker_count')->nullable();
            $table->boolean('has_outsource')->nullable();
            $table->boolean('has_investors')->nullable();
            $table->date('date_deadline')->nullable();
            $table->boolean('is_on_time')->nullable();
            $table->integer('payment_first_step')->nullable();
            $table->integer('payment_second_step')->nullable();
            $table->integer('payment_third_step')->nullable();
            $table->integer('payment_fourth_step')->nullable();
            $table->date('date_contract');
            $table->unsignedInteger('service_count')->nullable();
            $table->text('comment')->nullable();
            $table->decimal('efficiency', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
