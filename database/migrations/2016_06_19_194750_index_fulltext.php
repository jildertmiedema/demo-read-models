<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class IndexFulltext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //        DB::statement('ALTER TABLE search_items ADD FULLTEXT (text) WITH PARSER ngram');
        DB::statement('ALTER TABLE search_items ADD FULLTEXT search(text)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
