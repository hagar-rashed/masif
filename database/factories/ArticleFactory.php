<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'title_ar'    => $this->faker->name,
            'title_en'    => $this->faker->name,
            'desc_ar'     => $this->faker->text,
            'desc_en'     => $this->faker->text,
            'image'       => $this->faker->imageUrl,
            'category_id' => 1,
        ];
    }
}
