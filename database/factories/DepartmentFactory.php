<?php


namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;


class DepartmentFactory extends Factory
{
    /**
     *  Index of test image file
     *
     * @var int
     */
    private static $index = 0;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $pics = Storage::allFiles('logo');

        foreach ($pics as &$pic){
            $pic = explode('/',$pic)[1];
        }

        return [
            'name' => $this->faker->unique()->jobTitle,
            'description' => $this->faker->realText(),
            'logo' => $pics[self::$index++]
        ];
    }

}
