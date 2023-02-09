<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return  [
            'doc_content'=>$this->faker->paragraph(  10,   true),
           'doc_name'=>'file_name'.$this->faker->randomElement(['doc','txt','xlsv']),
           "doc_type"=>$this->faker->randomElement(['doc','txt','xlsv'])
       ];
    }
}
