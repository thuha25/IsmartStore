<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('product_price'); 
            $table->text('describe');
            $table->text('product_content');
            $table->text('thumbnail_path');
            $table->enum('status', ['Còn hàng', 'Hết hàng']);
            $table->unsignedBigInteger('category_id'); // Khóa ngoại liên kết với bảng cat_products
            $table->unsignedBigInteger('brand_id')->nullable(); // Khóa ngoại liên kết với bảng brand_products
            
            $table->timestamps();
             // Tạo các khóa ngoại
            $table->foreign('category_id')->references('id')->on('cat_products');
            $table->foreign('brand_id')->references('id')->on('brand_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
