<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_subitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_item_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->boolean('completed')->default(false);
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
        Schema::table('checklist_subitems', function (Blueprint $table) {
            //
        });
    }
};
