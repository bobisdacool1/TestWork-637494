<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Subscriber;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChannelAndSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = resolve(Faker::class);

        $channels = Channel::factory()->count(50)->create();
        $subscribers = Subscriber::factory()->count(50)->create();

        for ($i = 0; $i < 200; $i++) {
            DB::table('channel_subscriber')->insert(
                [
                    'channel_id' => $channels->random()->id,
                    'subscriber_id' => $subscribers->random()->id,
                    'description' => $faker->text(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
