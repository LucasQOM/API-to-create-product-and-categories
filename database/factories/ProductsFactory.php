<?php

namespace Database\Factories;

use App\Models\Products;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Products::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'categories_id' => Categories::inRandomOrder()->first()->id,
            'code' => $this->faker->numerify(),
            'price' => $this->faker->randomFloat(2, 0, 8),
            'file' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'size' => $this->faker->randomElement($array = array ('pp','p','m','g','gg')),
            'composition' => $this->faker->text(),
        ];
    }
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'file' => null,
            ];
        });
    }
}
