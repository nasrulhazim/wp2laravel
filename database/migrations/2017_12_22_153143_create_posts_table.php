<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->addForeign('user_id', 'users');
            $table->hashslug();
            $table->slug();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('old_url')->nullable();
            $table->standardTime();

            $table->referenceOn('user_id', 'users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
