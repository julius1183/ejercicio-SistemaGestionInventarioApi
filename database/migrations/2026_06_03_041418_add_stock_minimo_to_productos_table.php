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
       Schema::table('productos', function (Blueprint $table) {
           // Añade la columna con un valor por defecto de 0 para evitar conflictos con registros existentes
           $table->integer('stock_minimo')->default(0)->after('stock');
       });
   }

   public function down()
   {
       Schema::table('productos', function (Blueprint $table) {
           $table->dropColumn('stock_minimo');
       });
   }
};
