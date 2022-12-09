<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('keywords');
            $table->text('abstract');
            $table->string('talk_delivery_time');
            $table->string('use_dlt');
            $table->string('target_audience');
            $table->string('creator_role')->nullable();
            $table->string('creator_id')->default(0);
            $table->string('speaker_id')->default(0);
            $table->boolean('approved')->default(0);
            $table->unsignedInteger('approved_by')->default(0);
            $table->string('approved_at')->nullable();
            $table->string('client_username')->nullable();
            $table->string('client_password')->nullable();
            $table->string('client_dial_num')->nullable();
            $table->text('client_install_link')->nullable();
            $table->text('univ_id_to_notify')->nullable();
            $table->text('msg_sent_to_speaker')->nullable();
            $table->text('msg_sent_to_representative')->nullable();
            $table->string('seen_by')->nullable();
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
        Schema::dropIfExists('events');
    }
}
