<?php

use Illuminate\Database\Seeder;

class YundongyuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

          $ydy = factory(App\Model\Yundongyuan::class,1000)->create();
    }


}
