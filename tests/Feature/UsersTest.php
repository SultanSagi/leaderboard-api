<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * All users start with 0 points.
     *
     * @return void
     */
    public function test_start_with_zero_points()
    {
        $user = User::factory()->create();

        $this->assertSame(0, $user->points);
    }

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

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_increment_user_points()
    {
        $user = User::factory()->create();

        $this->post("api/users/{$user->id}/points");

        self::assertSame(1, $user->fresh()->points);

        $this->post("api/users/{$user->id}/points");

        self::assertSame(2, $user->fresh()->points);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_decrement_user_points()
    {
        $user = User::factory()->create();

        $this->post("api/users/{$user->id}/points");

        self::assertSame(1, $user->fresh()->points);

        $this->delete("api/users/{$user->id}/points");

        self::assertSame(0, $user->fresh()->points);
    }

    /**
     * The leaderboard updates and users are re-ordered based on score.
     *
     * @return void
     */
    public function test_reorder_based_on_score()
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $response = $this->post("api/users/{$secondUser->id}/points");

        $data = $response->json();

        $this->assertEquals([1, 0], array_column($data['data'], 'points'));
        $this->assertEquals([$secondUser->id, $firstUser->id], array_column($data['data'], 'id'));

        $this->post("api/users/{$firstUser->id}/points");
        $response = $this->post("api/users/{$firstUser->id}/points");

        $data = $response->json();

        $this->assertEquals([2, 1], array_column($data['data'], 'points'));
        $this->assertEquals([$firstUser->id, $secondUser->id], array_column($data['data'], 'id'));
    }
}
