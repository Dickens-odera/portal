<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applications;
class ApplicationManagerTest extends TestCase
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
        $response = $this->post('/applications',[
            'name'=>'Dickens Odera',
            'email'=>'odickens@student.mmust.ac.ke'
        ]);
        $response->assertOk();
        $this->assertCount(1, Applications::all());
    }
}
