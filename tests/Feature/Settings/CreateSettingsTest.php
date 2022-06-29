<?php

namespace Tests\Feature\Settings;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Setting;
use Tests\TestCase;
use App\Models\User;

class CreateSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_setting_can_be_created()
    {
        $user = User::factory()->create();

        $role = Role::firstOrcreate(['name' => 'admin']);
        $permission = Permission::firstOrcreate(['name' => 'manage_settings']);
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $name = 'theme_color';

        $response = $this->actingAs($user)->post('/settings', [
            'name'  => $name,
            'value' => 'purple',
            'scope' => '*',
        ]);

        
        $this->assertAuthenticated();

        $response->assertStatus(201);

        $createdSetting = Setting::where('name',$name)->first();

        $this->assertEquals($createdSetting->name, $name);
        $this->assertEquals($name, $response['data']['name']);
        $this->assertEquals($createdSetting->name, $response['data']['name']);

        $response->assertJson([
            'success' => true,
        ]);
    }

}
