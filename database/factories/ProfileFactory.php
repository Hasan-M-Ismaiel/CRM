<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = Array("male","female");
        $gender = $genders[array_rand($genders)];
        return [
            'user_id'           => rand(1, 11),
            'nickname'          => fake()->name(),
            'gender'            => $gender,
            'age'               => rand(20, 45),
            'phone_number'      => fake()->phoneNumber(),
            'city'              => fake()->city(),
            'country'           => fake()->country(),
            'postal_code'       => fake()->postcode(),
            'facebook_account'  => fake()->url(),
            'linkedin_account'  => fake()->url(),
            'github_account'    => fake()->url(),
            'twitter_account'   => fake()->url(),
            'instagram_account' => fake()->url(),
            'description'       => fake()->paragraph(),
        ];
    }
}
