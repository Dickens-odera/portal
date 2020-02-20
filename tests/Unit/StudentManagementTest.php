<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Student;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class StudentManagementTest extends TestCase
{
    use DatabaseMigrations;
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
    /**
     * @test
     * @return void
     */
    public function test_that_a_student_can_be_added()
    {
        $this->withoutExceptionHandling();
        $data = factory(Student::class)->make();
        //dd($data);
        $response = $this->post('/registrar/student-add',[
            'surname'=>$data->surname,
            'firstName'=>$data->firstName,
            'middlename'=>$data->middleName,
            'lastName'=>$data->lastName,
            'idNumber'=>$data->idNumber,
            'email'=>$data->email,
            'regNumber'=>$data->regNumber,
            'password'=>$data->password,
        ]);
        $response->assertOk();
        $this->assertCount(1, Student::all());
    }
    /**@test  */
    public function test_that_email_must_be_provided()
    {
        //$this->withoutExceptionHandling();
        $data = factory(Student::class)->make();
        $response = $this->post('/registrar/student-add',[
            'surname'=>$data->surname,
            'firstName'=>$data->firstName,
            'middleName'=>$data->middleName,
            'lastName'=>$data->lastName,
            'idNumber'=>$data->idNumber,
            'email'=>'',
            'regNumber'=>$data->regNumber,
            'password'=>$data->password
        ]);
        $response->assertSessionHasErrors('email');
    }
    /**
     *
     */
    private function request_data()
    {
        return [
            'name'=>'required'
        ];
    }
}
