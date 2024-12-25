<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\EventTypeEnum;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $eventTypes = array_filter(EventTypeEnum::toArray(), function ($type) {
            return $type !== EventTypeEnum::UserRegistered->value;
        });

        return [
            'user_id' => User::factory(),
            'event_type' => fake()->randomElement($eventTypes),
            'event_data' => [
                'amount' => fake()->randomFloat(2, 10, 1000),
            ],
            'description' => fake()->sentence(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now')
        ];
    }
}
