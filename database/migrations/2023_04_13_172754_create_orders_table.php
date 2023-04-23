<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->decimal('order_amount');
            $table->string('payment_status');
            $table->string('payment_method');
            $table->string('transaction_reference');
            $table->string('order_status');
            $table->string('status_id');
            $table->timestamp('confirmed');
            $table->timestamp('accepted');
            $table->tinyInteger('scheduled');
            $table->timestamp('processing');
            $table->timestamp('handover');
            $table->timestamp('failed');
            $table->timestamp('scheduled_at');
            $table->bigInteger('delivery_address_id');
            $table->text('order_note');
            $table->timestamps();// created_at and updated_at
            $table->decimal('delivery_charge');
            $table->text('delivery_address');
            $table->string('otp');
            $table->timestamp('pending');
            $table->timestamp('picked_up');
            $table->timestamp('delivered');
            $table->timestamp('canceled');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
