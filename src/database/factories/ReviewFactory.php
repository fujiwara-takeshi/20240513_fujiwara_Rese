<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;

class ReviewFactory extends Factory
{
    protected $model = Review::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(3, 100),
            'shop_id' => 1,
            'evaluation' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->text(400),
        ];
    }
}
