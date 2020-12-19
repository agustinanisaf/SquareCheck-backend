<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->group(['prefix' => 'users', 'middleware' => 'role:admin'], function () use ($router) {
        $router->get('', [
            'as' => 'user.index', 'uses' => 'UserController@index'
        ]);

        $router->get('{id}', [
            'as' => 'user.show', 'uses' => 'UserController@show'
        ]);

        $router->post('', [
            'as' => 'user.store', 'uses' => 'UserController@store'
        ]);

        $router->put('{id}', [
            'as' => 'user.update', 'uses' => 'UserController@update'
        ]);

        $router->delete('{id}', [
            'as' => 'user.destroy', 'uses' => 'UserController@destroy'
        ]);
    });

    $router->group(['prefix' => 'students'], function () use ($router) {
        $router->get('', [
            'as' => 'student.index', 'uses' => 'StudentController@index'
        ]);

        $router->group(['middleware' => 'role:admin'], function () use ($router) {
            $router->get('{id}', [
                'as' => 'student.show', 'uses' => 'StudentController@show'
            ]);

            $router->get('{id}/subjects', [
                'as' => 'student.getSubjects', 'uses' => 'StudentController@getSubjects'
            ]);

            $router->get('{id}/attendances', [
                'as' => 'student.getAttendances', 'uses' => 'StudentController@getAttendances'
            ]);
        });
    });

    $router->group(['prefix' => 'lecturers'], function () use ($router) {
        $router->get('', [
            'as' => 'lecturer.index', 'uses' => 'LecturerController@index'
        ]);

        $router->group(['middleware' => 'role:admin'], function () use ($router) {
            $router->get('{id}', [
                'as' => 'lecturer.show', 'uses' => 'LecturerController@show'
            ]);

            $router->get('{id}/subjects', [
                'as' => 'lecturer.getSubjects', 'uses' => 'LecturerController@getSubjects'
            ]);
        });
    });

    $router->group(['prefix' => 'departments', 'middleware' => 'role:admin'], function () use ($router) {
        $router->get('subjects', [
            'as' => 'department.getAllSubjects', 'uses' => 'DepartmentController@getAllSubjects'
        ]);

        $router->get('students', [
            'as' => 'department.getAllStudents', 'uses' => 'DepartmentController@getAllStudents'
        ]);

        $router->get('', [
            'as' => 'department.index', 'uses' => 'DepartmentController@index'
        ]);

        $router->get('{id}', [
            'as' => 'department.show', 'uses' => 'DepartmentController@show'
        ]);

        $router->get('{id}/students', [
            'as' => 'department.getStudents', 'uses' => 'DepartmentController@getStudents'
        ]);

        $router->get('{id}/lecturers', [
            'as' => 'department.getLecturers', 'uses' => 'DepartmentController@getLecturers'
        ]);

        $router->get('{id}/subjects', [
            'as' => 'department.getSubjects', 'uses' => 'DepartmentController@getSubjects'
        ]);
    });

    $router->group(['prefix' => 'classrooms', 'middleware' => 'role:admin'], function () use ($router) {
        $router->get('', [
            'as' => 'classroom.index', 'uses' => 'ClassroomController@index'
        ]);

        $router->get('{id}', [
            'as' => 'classroom.show', 'uses' => 'ClassroomController@show'
        ]);

        $router->get('{id}/students', [
            'as' => 'classroom.getStudents', 'uses' => 'ClassroomController@getStudents'
        ]);

        $router->get('{id}/subjects', [
            'as' => 'classroom.getSubjects', 'uses' => 'ClassroomController@getSubjects'
        ]);
    });

    $router->group(['prefix' => 'schedules'], function () use ($router) {
        $router->get('summarize', [
            'as' => 'schedule.summarize', 'uses' => 'ScheduleController@summarize'
        ]);

        $router->get('', [
            'as' => 'schedule.index', 'uses' => 'ScheduleController@index'
        ]);

        $router->get('{id}', [
            'as' => 'schedule.show', 'uses' => 'ScheduleController@show',
            'middleware' => 'role:lecturer-admin'
        ]);

        $router->get('{id}/attendances', [
            'as' => 'schedule.getAttendances', 'uses' => 'ScheduleController@getAttendances'
        ]);

        $router->put('{id}/attendances', [
            'as' => 'schedule.editAttendances', 'uses' => 'ScheduleController@editAttendances',
            'middleware' => 'role:admin'
        ]);

        $router->delete('{id}/attendances', [
            'as' => 'schedule.removeAttendances', 'uses' => 'ScheduleController@removeAttendances',
            'middleware' => 'role:lecturer-admin'
        ]);

        $router->post('{id}/attend', [
            'as' => 'schedule.attend', 'uses' => 'ScheduleController@attend',
            'middleware' => 'role:student-admin'
        ]);

        $router->post('{id}/open', [
            'as' => 'schedule.open', 'uses' => 'ScheduleController@open',
            'middleware' => 'role:lecturer-admin'
        ]);

        $router->post('{id}/close', [
            'as' => 'schedule.close', 'uses' => 'ScheduleController@close',
            'middleware' => 'role:lecturer-admin'
        ]);
    });

    // TODO: Open for public for the time being
    $router->group(['prefix' => 'subjects'], function () use ($router) {
        $router->get('', [
            'as' => 'subject.index', 'uses' => 'SubjectController@index'
        ]);

        $router->get('{id}', [
            'as' => 'subject.show', 'uses' => 'SubjectController@show'
        ]);

        $router->get('{id}/students', [
            'as' => 'subject.getStudents', 'uses' => 'SubjectController@getStudents'
        ]);

        $router->get('{id}/schedules', [
            'as' => 'subject.getSchedules', 'uses' => 'SubjectController@getSchedules'
        ]);

        $router->get('{id}/attendances', [
            'as' => 'subject.getAttendances', 'uses' => 'SubjectController@getAttendances'
        ]);
    });

    $router->group(['prefix' => 'academic-calendars'], function () use ($router) {
        $router->group(['prefix' => 'types'], function () use ($router) {
            $router->get('', [
                'as' => 'academicCalendarType.index', 'uses' => 'AcademicCalendarTypeController@index'
            ]);

            $router->get('{id}', [
                'as' => 'academicCalendarType.show', 'uses' => 'AcademicCalendarTypeController@show'
            ]);
        });

        $router->get('', [
            'as' => 'academicCalendar.index', 'uses' => 'AcademicCalendarController@index'
        ]);

        $router->get('{id}', [
            'as' => 'academicCalendar.show', 'uses' => 'AcademicCalendarController@show'
        ]);
    });
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', [
        'as' => 'auth.login', 'uses' => 'AuthController@login'
    ]);

    $router->post('logout', [
        'as' => 'auth.logout', 'uses' => 'AuthController@logout'
    ]);

    $router->post('refresh', [
        'as' => 'auth.refresh', 'uses' => 'AuthController@refresh'
    ]);

    $router->post('me', [
        'as' => 'auth.me', 'uses' => 'AuthController@me'
    ]);

    $router->post('register', [
        'as' => 'auth.register', 'uses' => 'AuthController@register'
    ]);
});
