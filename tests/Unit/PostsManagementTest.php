<?php

namespace Tests\Unit;

use App\Applications;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Posts;
class PostsManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    /** @test */
    public function test_that_an_application_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $data = factory(Applications::class)->make();
        $response = $this->post('/applications',[
            'student_name'=>$data->student_name,
            'student_phone'=>$data->student_phone,
            'reg_number'=>$data->reg_number
        ]);
        $response->assertOk();
        $app = Applications::first();
        //dd($app);
        $this->patch('/applications/'.$app->app_id,[
            'student_name'=>$app->student_name,
            'student_phone'=>$app->student_phone,
            'reg_number'=>$app->reg_number
        ]);
        $this->assertEquals($app->first()->student_name,Applications::first()->student_name);
    }
}
