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
    public function test_if_the_schools_index_page_exists()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('staff/schools');
        $response->assertStatus(200);
    }
}
