<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
     /**
     * @test
     */
    public function test_that_new_users_can_be_created()
    {
        $users = \factory(\App\User::class, 10)->create();
        $n = count($users) > 9;
        $this->assertTrue($n);
    }
    /**
     * @test
     */
    public function test_if_a_user_has_name()
    {
        $user = \factory(\App\User::class)->make();
        $name = $user->name;
        $this->assertNotEmpty($name);
    } 
}
