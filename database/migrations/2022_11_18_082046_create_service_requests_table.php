<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_admin_id')->nullable()->default(1)->constrained('users')->onDelete('set default');
            $table->foreignId('technician_id')->nullable()->default(2)->constrained('users')->onDelete('set default');
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->string('title');
            $table->integer('state');
            $table->double('costs_usd')->nullable();
            $table->date('expected_date_of_resolution')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('service_requests');
    }
};
