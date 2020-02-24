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
        $response = $this->post('/registrar/student-add',$this->request_data());
        $response->assertOk();
        $this->assertCount(1, Student::all());
    }
    /**@test  */
    public function test_that_email_must_be_provided()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/registrar/student-add',array_merge($this->request_data(),['email'=>'']));
        $response->assertSessionHasErrors('email');
    }
    /**
     * @test
    */
    public function test_that_regNumber_must_be_provided()
    {
       //$this->withoutExceptionHandling();
        $response = $this->post('/registrar/student-add', array_merge($this->request_data(),['regNumber'=>'']));
        $response->assertSessionHasErrors('regNumber');
    }
    /**
     * @return array
     */
    private function request_data()
    {
        $data = factory(Student::class)->make();
        return [
            'surname'=>$data->surname,
            'firstName'=>$data->firstName,
            'middleName'=>$data->middleName,
            'lastName'=>$data->lastName,
            'idNumber'=>$data->idNumber,
            'regNumber'=>$data->regNumber,
            'email'=>$data->email,
            'password'=>$data->password
        ];
    }
}
