<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function refreshTable($table)
    {
        DB::table($table)->truncate();
    }
    # test Add new user 

    public function test_user_can_be_created()
    {
        $this->refreshTable('users');
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];
        $response = $this->postJson('/api/User', $userData);
        $response->assertStatus(201);
        $this->assertCount(1, User::all());
    }

    # test update user

    public function test_user_can_be_updated()
    {        
        $this->refreshTable('users');
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $userData = [
            'name' => 'Test Update User',
            'email' => 'testUpdate@example.com',
            'password' => 'passwordUpdate',
        ];
        $response = $this->putJson('/api/User/' . $user->id, $userData);
        $response->assertStatus(202);
        $responseData = $response->json();
        $this->assertEquals('Test Update User', $responseData['name']);
        $this->assertEquals('testUpdate@example.com', $responseData['email']);
    }

    # test delete user 

    public function test_user_can_be_deleted()
    {
        $this->refreshTable('users');
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response = $this->deleteJson('/api/User/' . $user->id);
        $response->assertStatus(202);
    }
}