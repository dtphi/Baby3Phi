<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'categorys', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id', true);
            $table->string('name');
            $table->text('name_slug')->nullable();
            $table->string('tag')->nullable();
            $table->unsignedTinyInteger('column')->nullable()->comment('Vi tri hien thi danh muc');
            $table->text('image')->nullable();
            $table->unsignedBigInteger('parent_id')->default(0)->comment('Danh muc id');
            $table->unsignedTinyInteger('top')->default(0);
            $table->unsignedInteger('sort_id')->default(0);
            $table->unsignedTinyInteger('status')->default(1);

            $table->unsignedBigInteger('created_user')->nullable()->comment('Id cua nguoi tao');
            $table->unsignedBigInteger('update_user')->nullable()->comment('Id cua nguoi cap nhat');

            $table->softDeletes()->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(TBL_PREFIX . 'categorys');
    }
}
