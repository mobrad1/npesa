<?php

namespace Modules\Business\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Business\Entities\Business;

class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'business_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicates that the owner has been updated.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function ownerProfiled()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_completed_owner_profile' => true,
                'first_name'=> $this->faker->firstName(),
                'last_name'=> $this->faker->lastName(),
                'phone'=> $this->faker->unique()->phoneNumber(),
                'is_registered'=> $this->faker->randomElement([true, false]),
                'team_size'=> $this->faker->randomNumber(2)
            ];
        });
    }

     /**
     * Get the name of the model that is generated by the factory.
     *
     * @return string
     */
    public function modelName()
    {
       return Business::class;
    }


   
}
