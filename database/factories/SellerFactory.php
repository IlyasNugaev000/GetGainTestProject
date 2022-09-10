<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\SellerToken;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => Str::random(100),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Seller $seller) {
            $token = $seller->createToken('factory');

            $sellerToken = new SellerToken();

            $sellerToken->seller_id = $seller->id;
            $sellerToken->plain_text_token = $token->plainTextToken;

            $sellerToken->save();
        });
    }
}
