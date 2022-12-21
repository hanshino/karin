<?php

namespace Database\Seeders;

use App\Facade\Bouncer;
use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('superadmin')->everything();
        Bouncer::allow('admin')->everything();
    }
}
