<?php

namespace Database\Seeders;

use Database\Factories\ProductFactory;
use Database\Factories\SellerFactory;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * -Каждый продавец должен предлагать не менее 10000 товаров
         */
        $this->createSellersWithProducts(100, 10000);
        $this->createSellersWithProducts(10000, 100);

        /*
         * -Должен быть хотя бы один продавец, который предлагает не менее 100000 товаров
         */
        $this->createMassiveElemsInProducts(2);
        $this->createMassiveElemsInSellers(2);

        /*
         * -Должен быть один продавец исключение, который не предлагает товаров
         */
        $this->createSellersWithProducts(0, 1);
        $this->createSellersWithProducts(1, 0);

        /*
         * -Остальные данные
         */
        for ($i = 0; $i < 400000; $i++)
        {
            $this->createSellersWithProducts(2, 2);
        }
    }

    private function createMassiveElemsInProducts(int $productCount): void
    {
        $products = ProductFactory::new()->count($productCount)->create();

        foreach ($products as $product)
        {
            for ($i = 0; $i < 10; $i++)
            {
                SellerFactory::new()->hasAttached(
                    $product,
                    [
                        'price' => fake()->randomFloat(nbMaxDecimals:2, max: 1000000),
                        'quantity' => fake()->numberBetween()
                    ]
                )->count(10000)->create();
            }
        }
    }

    private function createMassiveElemsInSellers(int $sellersCount): void
    {
        $sellers = SellerFactory::new()->count($sellersCount)->create();

        foreach ($sellers as $seller)
        {
            for ($i = 0; $i < 10; $i++)
            {
                ProductFactory::new()->hasAttached(
                    $seller,
                    [
                        'price' => fake()->randomFloat(nbMaxDecimals:2, max: 1000000),
                        'quantity' => fake()->numberBetween()
                    ]
                )->count(10000)->create();
            }
        }
    }

    private function createSellersWithProducts(int $productCount, int $sellerCount): void
    {
        $products = ProductFactory::new()->count($productCount)->create();

        SellerFactory::new()->hasAttached(
            $products,
            [
                'price' => fake()->randomFloat(nbMaxDecimals:2, max: 1000000),
                'quantity' => fake()->numberBetween(),
                'created_at' => fake()->dateTime
            ]
        )->count($sellerCount)->create();
    }
}
