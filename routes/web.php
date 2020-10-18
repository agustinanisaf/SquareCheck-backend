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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('', [
            'as' => 'user.index', 'uses' => 'UserController@index' ]);

        $router->get('{id}', [
            'as' => 'user.show', 'uses' => 'UserController@show' ]);

        $router->post('', [
            'as' => 'user.store', 'uses' => 'UserController@store' ]);

        $router->put('{id}', [
            'as' => 'user.update', 'uses' => 'UserController@update' ]);

        $router->delete('{id}', [
            'as' => 'user.destroy', 'uses' => 'UserController@destroy' ]);

        $router->get('{id}/tokens', [
            'as' => 'user.getToken', 'uses' => 'UserController@getToken' ]);

        $router->post('{id}/tokens', [
            'as' => 'user.createToken', 'uses' => 'UserController@createToken' ]);

        // TODO: Add Student and Lecturer (and Admin, based on new Database design)
		});
		
		
		$router->group(['prefix' => 'student'], function () use ($router) {
			$router->get('', [
				'as' => 'student.index', 'uses' => 'StudentController@index' ]);

			$router->get('{id}', [
					'as' => 'student.show', 'uses' => 'StudentController@show' ]);
		});


		$router->group(['prefix' => 'lecturer'], function () use ($router) {
			$router->get('', [
				'as' => 'lecturer.index', 'uses' => 'LecturerController@index' ]);

			$router->get('{id}', [
					'as' => 'lecturer.show', 'uses' => 'LecturerController@show' ]);
		});


		$router->group(['prefix' => 'department'], function () use ($router) {
			$router->get('', [
				'as' => 'department.index', 'uses' => 'DepartmentController@index' ]);

			$router->get('{id}', [
					'as' => 'department.show', 'uses' => 'DepartmentController@show' ]);
		});


		$router->group(['prefix' => 'schedule'], function () use ($router) {
			$router->get('', [
				'as' => 'schedule.index', 'uses' => 'ScheduleController@index' ]);

			$router->get('{id}', [
					'as' => 'schedule.show', 'uses' => 'ScheduleController@show' ]);
		});


		$router->group(['prefix' => 'subject'], function () use ($router) {
			$router->get('', [
				'as' => 'subject.index', 'uses' => 'SubjectController@index' ]);

			$router->get('{id}', [
					'as' => 'subject.show', 'uses' => 'SubjectController@show' ]);
		});


		$router->group(['prefix' => 'academicCalendar'], function () use ($router) {
			$router->get('', [
				'as' => 'academicCalendar.index', 'uses' => 'AcademicCalendarController@index' ]);

			$router->get('{id}', [
					'as' => 'academicCalendar.show', 'uses' => 'AcademicCalendarController@show' ]);
		});


		$router->group(['prefix' => 'academicCalendarType'], function () use ($router) {
			$router->get('', [
				'as' => 'academicCalendarType.index', 'uses' => 'academicCalendarTypeController@index' ]);

			$router->get('{id}', [
					'as' => 'academicCalendarType.show', 'uses' => 'academicCalendarTypeController@show' ]);
		});
});
