<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_open_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }

    public function test_seeded_main_workflows_render(): void
    {
        $this->seed();

        $bidan = User::where('email', 'bidan@sipeka.test')->firstOrFail();
        $this->actingAs($bidan)
            ->get('/pasien')
            ->assertOk();

        $this->actingAs($bidan)
            ->get('/kunjungan')
            ->assertOk();

        $this->actingAs($bidan)
            ->get('/rujukan')
            ->assertOk();

        $this->actingAs($bidan)
            ->get('/edukasi')
            ->assertOk();

        $this->actingAs($bidan)
            ->get('/darurat')
            ->assertOk();

        $pasienUser = User::where('email', '3509015601940001@sipeka.local')->firstOrFail();
        $this->actingAs($pasienUser)
            ->get('/portal')
            ->assertOk();
    }

    public function test_role_access_is_enforced(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@sipeka.test')->firstOrFail();
        $bidan = User::where('email', 'bidan@sipeka.test')->firstOrFail();
        $dokter = User::where('email', 'dokter@sipeka.test')->firstOrFail();
        $pasien = User::where('email', '3509015601940001@sipeka.local')->firstOrFail();

        $this->actingAs($admin)->get('/admin/users')->assertOk();
        $this->actingAs($bidan)->get('/admin/users')->assertForbidden();

        $this->actingAs($dokter)->get('/rujukan')->assertOk();
        $this->actingAs($dokter)->get('/darurat')->assertForbidden();

        $this->actingAs($pasien)->get('/')->assertRedirect('/portal');
        $this->actingAs($pasien)->get('/pasien')->assertForbidden();
    }
}
