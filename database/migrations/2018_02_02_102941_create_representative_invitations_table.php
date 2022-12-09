<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresentativeInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representative_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invited_id');
            $table->unsignedInteger('invited_by')->default(0);
            $table->text('msg');
            $table->string('token');
            $table->timestamp('invited_at')->default(\Carbon\Carbon::now());
            $table->boolean('response')->default(0);
            $table->timestamp('responded_at')->nullable();
            $table->text('seen_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('representative_invitations');
    }
}
