<?php

use Illuminate\Database\Seeder;

class CrudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('cruds')->insert([
        	[
        		'nama' => 'Test',
        		'judul' => '123',

        	],
        	[
        		'nama' => 'test2',
        		'judul' => '1234',
        	]

        ]);
    }
}
