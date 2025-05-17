<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipe_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 45);
            $table->timestamps();
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 45)->nullable();
            $table->string('deskripsi', 100)->nullable();
            $table->integer('harga_beli')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->integer('jumlah')->nullable();
            $table->unsignedBigInteger('tipe_barang_id');
            $table->integer('safety_stok')->nullable();
            $table->integer('lead_time')->nullable();
            $table->timestamps();

            $table->foreign('tipe_barang_id')
                ->references('id')->on('tipe_barang')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->index('tipe_barang_id');
        });


        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->nullable();
            $table->string('alamat', 50)->nullable();
            $table->string('noTelp', 15)->nullable();
            $table->timestamps();
        });


        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('tipePembayaran', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->nullable();
            $table->string('alamat', 50)->nullable();
            $table->string('noTelp', 15)->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->string('po_id', 10);
            $table->dateTime('tanggal')->nullable();
            $table->string('status', 10)->nullable();
            $table->integer('totalHarga')->nullable();
            $table->unsignedBigInteger('pembayaran_id');
            $table->unsignedBigInteger('supplier_id');
            $table->timestamps();

            $table->foreign('pembayaran_id')
                ->references('id')->on('pembayaran')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('supplier_id')
                ->references('id')->on('supplier')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->index('pembayaran_id');
            $table->index('supplier_id');
        });

        Schema::create('purchase_order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah')->nullable();
            $table->integer('harga')->nullable();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('purchase_order_id');
            $table->timestamps();

            $table->foreign('barang_id')
                ->references('id')->on('barang')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('purchase_order_id')
                ->references('id')->on('purchase_order')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->index('barang_id');
            $table->index('purchase_order_id');
        });

        Schema::create('sales_order', function (Blueprint $table) {
            $table->id();
            $table->string('so_id', 45);
            $table->dateTime('tanggal')->nullable();
            $table->string('status', 10)->nullable();
            $table->integer('totalHarga')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('pembayaran_id');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')->on('customer')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('pembayaran_id')
                ->references('id')->on('pembayaran')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->index('customer_id');
            $table->index('pembayaran_id');
        });

        Schema::create('sales_order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah')->nullable();
            $table->integer('harga')->nullable();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('sales_order_id');
            $table->timestamps();

            $table->foreign('barang_id')
                ->references('id')->on('barang')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('sales_order_id')
                ->references('id')->on('sales_order')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->index('barang_id');
            $table->index('sales_order_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_order_detail');
        Schema::dropIfExists('sales_order');
        Schema::dropIfExists('purchase_order_detail');
        Schema::dropIfExists('purchase_order');
        Schema::dropIfExists('supplier');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('tipe_barang');
    }
};
