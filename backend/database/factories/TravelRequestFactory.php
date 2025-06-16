<?php

namespace Database\Factories;

use App\Enum\StatusEnum;
use App\Models\TravelRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelRequest>
 */
class TravelRequestFactory extends Factory
{
    protected $model = TravelRequest::class;
    
    public function definition()
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'requester_name' => $user->name,
            'destination' => $this->faker->city,
            'departure_date' => Carbon::now()->addDays(10)->toDateString(),
            'return_date' => Carbon::now()->addDays(15)->toDateString(),
            'status' => StatusEnum::SOLICITADO,
        ];
    }
}
