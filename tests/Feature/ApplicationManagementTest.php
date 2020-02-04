<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applications;
use App\User;
class ApplicationManagementTest extends TestCase
{
    use RefreshDatabase;
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
     *
     */
    public function test_that_an_application_can_be_added()
    {
        $this->withoutExceptionHandling();
        factory(Applications::class, 1)->create();
        $this->assertCount(1, Applications::all());
        /*
        $response = $this->post('/applications',
        [
            'student_name'=>'Dickens Odera',
            'reg_number'=>'COM/B/01-02204/2016',
            'student_phone'=>'0714905613'
        ]);
        $response->assertOk();
        $this->assertCount(1, Applications::all());
        */
    }

}
