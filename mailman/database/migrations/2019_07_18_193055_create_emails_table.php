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
            $table->string('client_id')->nullable()->default(null);
            $table->unsignedBigInteger('service_id')->nullable()->default(null);
            $table->string('custom_id')->nullable()->default(null);
            $table->string('message_id')->nullable()->default(null);
            $table->string('to_email', 70);
            $table->string('to_name');
            $table->string('from_email', 70);
            $table->string('from_name');
            $table->string('subject');
            $table->tinyInteger('priority')->default(3);
            $table->text('markdown')->nullable()->default(null);
            $table->text('text')->nullable()->default(null);
            $table->text('html')->nullable()->default(null);

            $table->timestamps();
            $table->softDeletes();

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
