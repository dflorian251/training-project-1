<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Event::create(array(
            'name' => 'First event',
            'public' => 1,
            'date' => Carbon::now()->addDays(5),
            'people_attended' => 20,
        ));

        Event::create(array(
            'name' => 'Second event',
            'public' => 0,
            'date' => Carbon::now()->addDays(10),
            'people_attended' => 50,
        ));

        Event::create(array(
            'name' => 'Another one',
            'public' => 1,
            'date' => Carbon::now()->addDays(7),
            'people_attended' => 10,
        ));
    }
}
