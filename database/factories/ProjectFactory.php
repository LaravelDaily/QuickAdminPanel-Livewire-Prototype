<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(200),
            'type' => ['type1', 'type2', 'type3'][rand(0,2)],
            'category' => ['category1', 'category2', 'category3'][rand(0,2)],
            'is_active' => rand(0,1),
            'price' => rand(100, 9999),
            'author_id' => User::factory(),
        ];
    }
}
