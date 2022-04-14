<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelSubscriberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_subscriber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained('channels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('subscriber_id')->constrained('subscribers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**]
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_subscriber');
    }
}
