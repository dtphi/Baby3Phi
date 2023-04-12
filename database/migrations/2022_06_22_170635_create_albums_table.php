<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'albums', function (Blueprint $table) {
            $table->id();
            $table->string('albums_name', 255)->nullable()->comment('Ten cua album');
            $table->unsignedBigInteger('group_albums_id')->nullable()->comment('Id cua danh muc album');
            $table->unsignedTinyInteger('status')->default(1)->comment('Trang thai an hien');
            $table->string('image_origin', 255)->nullable()->comment('Path hinh anh goc');
            $table->string('image_thumb', 255)->nullable()->comment('Path hinh anh nho');
            $table->unsignedInteger('sort_id')->default(0)->comment('Thu tu sap xep');
            $table->text('image')->nullable()->comment('Path hinh anh hien thi');

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
        Schema::dropIfExists(TBL_PREFIX . 'albums');
    }
}
