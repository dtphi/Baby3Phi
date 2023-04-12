<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TBL_PREFIX . 'category_descriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('	category_description_id', true);
            $table->unsignedBigInteger('category_id')->comment('Id danh muc');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();

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
        Schema::dropIfExists(TBL_PREFIX . 'category_descriptions');
    }
}
