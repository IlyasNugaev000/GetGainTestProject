<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAvailableCars()
    {
        Car::factory()->create();

        $response = $this->json('GET', "api/available-cars");
        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'state_number'
                        ]
                    ]
                ]
            );
    }

    public function testGetAvailableCarsIfCarsNotAvailable() {
        $user = User::factory()->create();
        $car = Car::factory()->create();
        $car->user_id = $user->id;
        $car->save();

        $response = $this->json('GET', "api/available-cars");
        $response
            ->assertStatus(400)
            ->assertJsonStructure(
                [
                    'success',
                    'error' => [
                        'code',
                        'message'
                    ]
                ]
            );
    }

    public function testGetUserWithCarIfCarNotFound()
    {
        $user = User::factory()->create();

        $response = $this->json('GET', "api/user/" . $user->id . "/car");
        $response
            ->assertStatus(400)
            ->assertJsonStructure(
                [
                    'success',
                    'error' => [
                        'code',
                        'message'
                    ]
                ]
            );
    }

    public function testGetUserWithCar()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();
        $car->user_id = $user->id;
        $car->save();

        $response = $this->json('GET', "api/user/".$user->id."/car");
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }
}
