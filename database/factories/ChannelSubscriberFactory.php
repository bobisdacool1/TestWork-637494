<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelSubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $channelsAmount = Channel::count();
        $subscriberAmount = Subscriber::count();

        return [
            'channel_id' => $this->faker->numberBetween(1, $channelsAmount),
            'subscriber_id' => $this->faker->numberBetween(1, $subscriberAmount),
            'description' => $this->faker->sentence(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
