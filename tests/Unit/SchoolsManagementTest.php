<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Schools;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolsManagementTest extends TestCase
{
    use RefreshDatabase;
    /* @test*/
    public function test_if_a_school_can_be_added()
    {
        $this->withoutExceptionHandling();
        $data = factory(Schools::class)->make();
        $response = $this->post('/addschool',[
            'school_name'=>$data->school_name
        ]);
        $response->assertOk();
        $this->assertCount(1, Schools::all());
    }
    /**@test */
    public function test_if_the_schools_index_page_exists()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('staff/schools');
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function test_that_a_school_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $schools = \factory(Schools::class)->make();
        $response = $this->post('/addschool',[
            'school_name'=>$schools->school_name
        ]);
        $response->assertOk();
        $this->assertCount(1,Schools::all());
        $data = Schools::first();
        $update_res = $this->patch('/updateschool/'.$data->school_id,[
            'school_name'=>$data->school_name
        ]);
        $update_res->assertOk();
        $this->assertEquals($data->school_name, Schools::first()->school_name);
        //dd($data);
    }
    /**
     * @test
     */
    public function test_school_deletion()
    {
        $this->withoutExceptionHandling();
        //fetch the schools
        $data = factory(Schools::class)->make();
        $res = $this->post('/addschool',[
            'school_name'=>$data->school_name
        ]);
        $res->assertOk();
        $this->assertCount(1, Schools::all());
        $schools = Schools::first();
        //dd($schools);
        $response = $this->delete('/deleteSchool/'.$schools->school_id);
        $response->assertOk();
        $this->assertCount(0, Schools::all());
    }
}
