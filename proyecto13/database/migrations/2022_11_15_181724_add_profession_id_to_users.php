<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfessionIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // clave foranea tabla professions // debe ser el mismo tipo de dato
            $table->unsignedInteger('profession_id')
                ->nullable() // puede ser nulo
                ->after('password');
            // enlazar clave foranea con la tabla de la que procede
            $table->foreign('profession_id')
                ->references('id')
                ->on('professions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profession_id');
        });
    }
}