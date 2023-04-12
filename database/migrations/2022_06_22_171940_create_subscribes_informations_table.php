<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribesInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'subscribes_informations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscribe_id')->comment('Id cua nguoi dang ky');
            $table->unsignedBigInteger('information_id')->comment('Id cua tin tuc dang ky');
            $table->unsignedBigInteger('viewed')->nullable()->comment('So lan xem tin');
            $table->timestamp('last_viewed_in_at')->useCurrent();

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
        Schema::dropIfExists(TBL_PREFIX . 'subscribes_informations');
    }
}
