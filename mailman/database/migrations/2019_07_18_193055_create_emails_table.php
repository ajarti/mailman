<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {

            // Fields
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');
            $table->string('custom_id');
            $table->string('message_id');
            $table->string('to_email', 70);
            $table->string('to_name');
            $table->string('from_email', 70);
            $table->string('from_name');
            $table->string('subject');
            $table->tinyInteger('priority');
            $table->text('markdown')->nullable()->default(null);
            $table->text('text')->nullable()->default(null);
            $table->text('html')->nullable()->default(null);

            $table->softDeletes();
            $table->timestamps();

            // Indexes


        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
