<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name', 200);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->enum('product_type', ['physical', 'digital', 'service', 'handicraft']);
            $table->string('dimensions', 100)->nullable();
            $table->string('materials', 200)->nullable();
            $table->decimal('weight_kg', 6, 2)->nullable();
            $table->string('main_image')->nullable();
            $table->enum('status', ['available', 'sold_out', 'paused'])->default('available');
            $table->boolean('is_featured')->default(false);
            $table->integer('sales_count')->default(0);
            $table->timestamps();

            // Índices
            $table->index('user_id');
            $table->index('category_id');
            $table->index('status');
            $table->index('is_featured');
        });
    }

    public function down() {
        Schema::dropIfExists('products');
    }
};