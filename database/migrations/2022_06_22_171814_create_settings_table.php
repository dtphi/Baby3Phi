<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'settings', function (Blueprint $table) {
            $table->id();
            $table->string('code', 128)->comment('Ma tao nhom phan biet');
            $table->string('key_data', 128)->comment('Khoa phan biet gia tri trong nhom');
            $table->longText('value')->nullable()->comment('Gia tri cua cau hinh');
            $table->unsignedTinyInteger('serialized')->default(0)->comment('1:kieu serialize, 0: kieu chuoi');

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
        Schema::dropIfExists(TBL_PREFIX . 'settings');
    }
}
