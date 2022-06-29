<?php

namespace Tests\Feature\Settings;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Models\User;

class GetSettingsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_fetch_settings()
    {

        $user = User::factory()->create();

        $role = Role::firstOrcreate(['name' => 'admin']);
        $permission = Permission::firstOrcreate(['name' => 'manage_settings']);
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $response = $this->actingAs($user)->get('/settings');

        
        $this->assertAuthenticated();

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
        ]);
    }
}
