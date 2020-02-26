<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applications;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApplicationManagementTest extends TestCase
{
    //use RefreshDatabase;
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    /**
     * @test
     *
     */
    public function test_that_an_application_can_be_added()
    {
        $this->withoutExceptionHandling();
        $data =  factory(Applications::class)->make();
        $response = $this->post('/applications',
        [
            'student_name'=>$data->student_name,
            'reg_number'=>$data->reg_number,
            'student_phone'=>$data->student_phone
        ]);
        $response->assertOk();
        $this->assertCount(1, Applications::all());
    }
}
