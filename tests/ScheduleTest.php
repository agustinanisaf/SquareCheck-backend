<?php

use App\Models\Schedule;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ScheduleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::find(1);
        $this->lecturer = User::find(2);
        $this->student = User::find(52);
    }

    public function testAsLecturerShouldReturnCurrentSchedule()
    {
        // arrange
        $this->actingAs($this->lecturer);

        // act
        $response = $this->get("api/schedules/now");

        // assert
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => ['id', 'subject', 'time', 'start_time', 'end_time'],
        ]);
        $response->seeJson(['start_time' => null]);
        $response->seeJson(['end_time' => null]);
    }

    public function testAsStudentShouldReturnCurrentSchedule()
    {
        // arrange
        $this->actingAs($this->student);

        // act
        $response = $this->get("api/schedules/now");

        // assert
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => ['id', 'subject', 'time', 'start_time', 'end_time'],
        ]);
        $response->dontSeeJson(['start_time' => null]);
        $response->seeJson(['end_time' => null]);
    }
}
