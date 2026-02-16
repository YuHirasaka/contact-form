<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $details = [
            1 => ['配送が遅れています。確認お願いします。'],
            2 => ['不良品だったため交換希望です。'],
            3 => ['商品に傷がありました。'],
            4 => ['営業時間について教えてください。'],
            5 => ['その他のお問い合わせです。'],
        ];
        $category = $this->faker->numberBetween(1,5);

        return [
            'first_name' => $this->faker->lastName,
            'last_name' => $this->faker->firstName,
            'gender' => $this->faker->randomElement([1,2,3]),
            'email' => $this->faker->safeEmail,
            'tel' => $this->faker->numerify('080########'),
            'address' => $this->faker->address,
            'building' => $this->faker->secondaryAddress,
            'category_id' => $category,
            'detail' => $this->faker->randomElement($details[$category]),
        ];
    }
}
