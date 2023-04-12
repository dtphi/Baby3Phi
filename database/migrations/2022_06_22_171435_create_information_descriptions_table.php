<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'information_descriptions', function (Blueprint $table) {
          $table->unsignedBigInteger('information_id')->comment('Id tin tuc');
          $table->string('name')->comment('Ten cua tin tuc');
          $table->longText('description')->comment('Noi dung mo ta');
          $table->text('tag')->nullable()->comment('Cac Id cua tag tin tuc');
          $table->string('meta_title')->comment('Meta title cua tin tuc');
          $table->text('meta_description')->nullable()->comment('Meta mo ta ngan');
          $table->text('meta_keyword')->nullable()->comment('Keyword');

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
        Schema::dropIfExists(TBL_PREFIX . 'information_descriptions');
    }
}
