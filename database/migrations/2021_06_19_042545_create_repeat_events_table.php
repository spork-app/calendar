<?php

use App\Models\FeatureList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepeatEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repeat_events', function (Blueprint $table) {
            $table->id();

            $table->string("repeatable_type")->nullable();
            $table->unsignedBigInteger("repeatable_id")->nullable();
            $table->index(["repeatable_type", "repeatable_id"]);


            $table->string('name');

            $table->string('color')->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();


            $table->string('interval')->nullable();
            $table->string('frequency')->nullable();

            $table->foreignIdFor(FeatureList::class);
            $table->foreignIdFor(App\Models\User::class);

            $table->string('weekday_start')->nullable();
            $table->integer('number_of_occurrences')->nullable();
            $table->string('for_months')->nullable();
            $table->string('for_week_numbers')->nullable();
            $table->string('for_year_day')->nullable();
            $table->string('for_month_day')->nullable();
            $table->string('for_day')->nullable();
            $table->string('for_hour')->nullable();
            $table->string('for_minute')->nullable();
            $table->string('for_second')->nullable();
            $table->string('for_set_position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repeat_events');
    }
}
