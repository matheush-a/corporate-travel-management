<?php

namespace Tests\Feature;

use App\Enum\StatusEnum;
use App\Models\TravelRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelRequestControllerTest extends TestCase
{
    use RefreshDatabase;

    // Auxiliar para fazer login e configurar token JWT no header
    private function authenticateUser(User $user): string
    {
        $responseLogin = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Umasupersenha123', // Senha fixa para testes
        ]);

        $responseLogin->assertStatus(200);

        return $responseLogin->json('token');
    }

    private function actingWithJwt(User $user)
    {
        $token = $this->authenticateUser($user);

        return $this->withHeaders([
            'Authorization' => "Bearer $token",
        ]);
    }

    public function test_index_returns_all_requests()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        TravelRequest::factory()->count(3)->create([
            'user_id' => $user->id,
            'requester_name' => $user->name,
        ]);

        $response = $this->actingWithJwt($user)->getJson('/api/travel-requests');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_index_filters_by_status()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        TravelRequest::factory()->create([
            'status' => StatusEnum::APROVADO,
            'user_id' => $user->id,
            'requester_name' => $user->name,
        ]);

        TravelRequest::factory()->create([
            'status' => StatusEnum::CANCELADO,
            'user_id' => $user->id,
            'requester_name' => $user->name,
        ]);

        $response = $this->actingWithJwt($user)->getJson('/api/travel-requests?status=' . StatusEnum::APROVADO);

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['status' => StatusEnum::APROVADO]);
    }

    public function test_show_returns_a_request()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $request = TravelRequest::factory()->create([
            'user_id' => $user->id,
            'requester_name' => $user->name,
        ]);

        $response = $this->actingWithJwt($user)->getJson("/api/travel-requests/{$request->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $request->id]);
    }

    public function test_show_returns_204_if_not_found()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingWithJwt($user)->getJson("/api/travel-requests/999");

        $response->assertStatus(204);
    }

    public function test_store_creates_a_request()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $data = [
            'destination' => 'São Paulo',
            'departure_date' => Carbon::now()->addDays(10)->toDateString(),
            'return_date' => Carbon::now()->addDays(15)->toDateString(),
        ];

        $response = $this->actingWithJwt($user)->postJson('/api/travel-requests', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['destination' => 'São Paulo']);
    }

    public function test_store_fails_with_invalid_data()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingWithJwt($user)->postJson('/api/travel-requests', [
            'destination' => '',
        ]);

        $response->assertStatus(422);
    }

    public function test_update_status_successfully()
    {
        /** @var \App\Models\User $manager */
        $manager = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        /** @var \App\Models\User $employee */
        $employee = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $request = TravelRequest::factory()->create([
            'user_id' => $employee->id,
            'requester_name' => $employee->name,
            'departure_date' => Carbon::now()->addDays(10)->toDateString(),
            'status' => StatusEnum::SOLICITADO,
        ]);

        $response = $this->actingWithJwt($manager)->putJson("/api/travel-requests/{$request->id}", [
            'status' => StatusEnum::APROVADO,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => StatusEnum::APROVADO]);
    }

    public function test_update_rejects_if_user_is_owner()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $request = TravelRequest::factory()->create([
            'user_id' => $user->id,
            'requester_name' => $user->name,
        ]);

        $response = $this->actingWithJwt($user)->putJson("/api/travel-requests/{$request->id}", [
            'status' => StatusEnum::CANCELADO,
        ]);

        $response->assertStatus(401);
    }

    public function test_update_rejects_if_departure_is_too_soon()
    {
        /** @var \App\Models\User $manager */
        $manager = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        /** @var \App\Models\User $employee */
        $employee = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $request = TravelRequest::factory()->create([
            'user_id' => $employee->id,
            'requester_name' => $employee->name,
            'departure_date' => Carbon::now()->addDays(3)->toDateString(),
        ]);

        $response = $this->actingWithJwt($manager)->putJson("/api/travel-requests/{$request->id}", [
            'status' => StatusEnum::CANCELADO,
        ]);

        $response->assertStatus(422);
    }
}
