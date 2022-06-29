<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormField>
 */
class FormFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'first_name',
            'category' => 'basic_details',
            'field_id' => 'first_name',
            'type' => 'text',
            'parent_classes' => 'col-4',
            'min' => 3,
            'max' => 255,
            'active' => 1,
            'menu_order' => 0,
        ];
    }
}
