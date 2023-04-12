<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'layout_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layout_id')->comment('Id cua layout');
            $table->string('code', 128)->comment('Ma phan biet');
            $table->longText('value')->comment('Noi dung cau hinh cua layout');
            $table->unsignedTinyInteger('serialized')->default(0)->comment('0:kieu chuoi, 1:kieu serialize, 2:kieu mang chuoi');

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
        Schema::dropIfExists(TBL_PREFIX . 'layout_settings');
    }
}
