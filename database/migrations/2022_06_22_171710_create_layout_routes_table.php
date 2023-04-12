<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'layout_routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layout_id')->comment('Id cua layout');
            $table->text('route')->comment('Segments cua url tren thanh address url');

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
        Schema::dropIfExists(TBL_PREFIX . 'layout_routes');
    }
}
