<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoginTest extends TestCase
{
    protected function refreshTable($table)
    {
        DB::table($table)->truncate();
    }
    # test Add new user 

    public function test_user_can_be_registred() {
        $this->refreshTable('users');
        $userData = [
            'name' => 'Test User',
            'email' => 'othman@gmail.com',
            'password' => 'password'
        ];
        $response = $this->postJson('/api/Register', $userData);
        $response->assertStatus(200);
        $this->assertCount(1, User::all());
    }
}