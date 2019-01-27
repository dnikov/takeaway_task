<?php

use Illuminate\Database\Seeder;
use App\Consumer;

class ConsumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Consumer::class, 10)->create();
    }
}
