<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class createStatisticTable
{
    public function up() {
        Capsule::schema()->create('statistic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('numbers');
            $table->integer('duration');
            $table->integer('total_numbers');;
            $table->integer('total_duration');
        });
    }

    public function down() {
        Capsule::schema()->dropIfExists('statistic');
    }
}