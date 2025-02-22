<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->enum('type', ['one-time', 'recurring'])->default('one-time')->after('amount');
            $table->string('recurring_interval')->nullable()->after('type'); // z. B. 'monthly', 'weekly'
        });
    }

    public function down()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn(['type', 'recurring_interval']);
        });
    }
};
