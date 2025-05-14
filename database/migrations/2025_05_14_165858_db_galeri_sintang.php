<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbGaleriSintangTables extends Migration
{
    public function up()
    {
        Schema::create('tipe_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 45);
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
            $table->foreign('tipe_barang_id')->references('id')->on('tipe_barang')->onUpdate('no action')->onDelete('no action');
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key', 255)->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key', 255)->primary();
            $table->string('owner', 255);
            $table->integer('expiration');
        });

        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->nullable();
            $table->string('alamat', 50)->nullable();
            $table->string('noTelp', 15)->nullable();
        });

        Schema::create('migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration', 255);
            $table->integer('batch');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 255);
            $table->string('token', 255);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('tipePembayaran', 20)->nullable();
        });

        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->nullable();
            $table->string('alamat', 50)->nullable();
            $table->string('noTelp', 15)->nullable();
        });

        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->string('po_id', 10);
            $table->dateTime('tanggal')->nullable();
            $table->string('status', 10)->nullable();
            $table->integer('totalHarga')->nullable();
            $table->unsignedBigInteger('pembayaran_id');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('pembayaran_id')->references('id')->on('pembayaran')->onUpdate('no action')->onDelete('no action');
            $table->foreign('supplier_id')->references('id')->on('supplier')->onUpdate('no action')->onDelete('no action');
        });

        Schema::create('purchase_order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah')->nullable();
            $table->integer('harga')->nullable();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('purchase_order_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('no action')->onDelete('no action');
            $table->foreign('purchase_order_id')->references('id')->on('purchase_order')->onUpdate('no action')->onDelete('no action');
        });

        Schema::create('sales_order', function (Blueprint $table) {
            $table->id();
            $table->string('so_id', 45);
            $table->dateTime('tanggal')->nullable();
            $table->string('status', 10)->nullable();
            $table->integer('totalHarga')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('pembayaran_id');
            $table->foreign('customer_id')->references('id')->on('customer')->onUpdate('no action')->onDelete('no action');
            $table->foreign('pembayaran_id')->references('id')->on('pembayaran')->onUpdate('no action')->onDelete('no action');
        });

        Schema::create('sales_order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah')->nullable();
            $table->integer('harga')->nullable();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('sales_order_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('no action')->onDelete('no action');
            $table->foreign('sales_order_id')->references('id')->on('sales_order')->onUpdate('no action')->onDelete('no action');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('role', 255)->default('karyawan');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('sales_order_detail');
        Schema::dropIfExists('sales_order');
        Schema::dropIfExists('purchase_order_detail');
        Schema::dropIfExists('purchase_order');
        Schema::dropIfExists('supplier');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('tipe_barang');
    }
}
