<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_user()
    {
        $user = User::factory()->raw();

        $this->post('api/users', $user)
            ->assertCreated();

        $this->assertDatabaseHas('users', ['name' => $user['name']]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_users()
    {
        $user = User::factory()->create();

        $this->get('api/users')
            ->assertSee($user->name);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_delete_user()
    {
        $user = User::factory()->create();

        $this->delete("api/users/{$user->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
