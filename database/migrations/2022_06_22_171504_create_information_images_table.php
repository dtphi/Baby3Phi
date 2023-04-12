<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'information_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('information_id')->comment('Id tin tuc');
            $table->unsignedBigInteger('album_id')->nullable()->comment('Id album');
            $table->text('image')->nullable()->comment('Duong dan hinh anh tin tuc');
            $table->unsignedBigInteger('sort_order')->default(0)->comment('Sap xep thu tu');

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
        Schema::dropIfExists(TBL_PREFIX . 'information_images');
    }
}
