<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogParentArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_parent_article', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');

            $table->foreign('parent_id')
                ->references('id')
                ->on('blog_articles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('child_id')
                ->references('id')
                ->on('blog_articles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_parent_article');
    }
}
