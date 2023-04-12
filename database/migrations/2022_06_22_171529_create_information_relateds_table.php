<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationRelatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'information_relateds', function (Blueprint $table) {
          $table->unsignedBigInteger('information_id')->comment('Id tin tuc');
          $table->unsignedBigInteger('related_id')->comment('Id tin tuc lien quan');

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
        Schema::dropIfExists(TBL_PREFIX . 'information_relateds');
    }
}
