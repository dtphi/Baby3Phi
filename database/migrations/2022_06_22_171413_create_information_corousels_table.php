<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationCorouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'information_corousels', function (Blueprint $table) {
          $table->unsignedBigInteger('information_id')->comment('Id tin tuc');
          $table->string('name')->comment('Ten cua tin tuc');
          $table->text('name_slug')->comment('Ten slug');
          $table->text('sort_description')->nullable()->comment('Mo ta ngan');
          $table->longText('description')->nullable()->comment('Noi dung mo ta');
          $table->text('image_origin')->nullable()->comment('Hinh anh goc');
          $table->text('image')->nullable()->comment('Hinh anh');
          $table->unsignedBigInteger('sort_order')->default(0)->comment('Sap xep thu tu');
          $table->dateTime('date_available')->nullable()->comment('Ngay tin se hien thi');
          $table->unsignedTinyInteger('information_type')->default(1)->comment('1.Loai tin, 2.Loai video');
          $table->unsignedBigInteger('viewed')->default(0)->comment('So lan xem tin');
          $table->unsignedBigInteger('vote')->default(0)->comment('So lan binh chon tin');

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
        Schema::dropIfExists(TBL_PREFIX . 'information_corousels');
    }
}
