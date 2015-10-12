<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTextPlacementDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE slides MODIFY COLUMN text_placement varchar(255) NOT NULL DEFAULT 'under';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE slides MODIFY COLUMN text_placement varchar(255) NOT NULL DEFAULT 'overlay';");
    }
}
