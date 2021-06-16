<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evaluation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company' => (string) Str::uuid(),
            'comment' => $this->faker->sentence(10),
            'stars' => 5
        ];
    }
}
