<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ClassroomAnnouncementController;
use App\Http\Controllers\Api\BranchAnnouncementController;
use App\Http\Controllers\Api\ListForStudentController;
use App\Http\Controllers\Api\ListForTeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

                    /* Everyone can watch */
    //Announcement Route
    Route::get('get-list-announcement', [AnnouncementController::class, 'getAnnouncements']);
    Route::get('get-list-announcement/{id}', [AnnouncementController::class, 'getAnnouncement']);
    //Classroom Announcement Route
    Route::get('get-list-class-announcement', [ClassroomAnnouncementController::class, 'getAnnouncements']);
    Route::get('get-list-class-announcement/{id}', [ClassroomAnnouncementController::class, 'getAnnouncement']);
    //Branch Announcement Route
    Route::get('get-list-branch-announcement', [BranchAnnouncementController::class, 'getAnnouncements']);
    Route::get('get-list-branch-announcement/{id}', [BranchAnnouncementController::class, 'getAnnouncement']);
    //List
    Route::get('get-all-teachers', [ListForTeacherController::class, 'getAllTeachers'])->middleware('auth:sanctum');
    Route::get('get-all-students', [ListForStudentController::class, 'getAllStudents'])->middleware('auth:sanctum');
    Route::get('get-all-books', [BookController::class, 'getAllBook'])->middleware('auth:sanctum');
    
    

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
Route::group([
    'prefix' => 'admin'
], function () {
    //Personal Route
    Route::post('add-personal', [UserController::class, 'CreatePersonal'])->middleware('auth:sanctum');
    Route::delete('delete-personal/{id}', [UserController::class, 'deletePersonal'])->middleware('auth:sanctum');
    //Teacher Route
    Route::post('add-teacher', [UserController::class, 'CreateTeacher'])->middleware('auth:sanctum');
    Route::delete('delete-teacher/{id}', [UserController::class, 'deleteTeacher'])->middleware('auth:sanctum');
    //Student Route
    Route::post('add-student', [UserController::class, 'CreateStudent'])->middleware('auth:sanctum');
    Route::delete('delete-student/{id}', [UserController::class, 'deleteStudent'])->middleware('auth:sanctum');

});
Route::group([
    'prefix' => 'personal'
], function () {
    //Announcement Route
    Route::post('add-announcement', [AnnouncementController::class, 'addAnnouncement'])->middleware('auth:sanctum');
    Route::post('update-announcement/{id}', [AnnouncementController::class, 'updateAnnouncement'])->middleware('auth:sanctum');
    Route::delete('delete-announcement/{id}', [AnnouncementController::class, 'deleteAnnouncement'])->middleware('auth:sanctum');
    //Class Route
    Route::post('add-classroom', [ClassroomController::class, 'addClassroom'])->middleware('auth:sanctum');
    Route::post('update-classroom/{id}', [ClassroomController::class, 'updateClassroom'])->middleware('auth:sanctum');
    Route::delete('delete-classroom/{id}', [ClassroomController::class, 'deleteClassroom'])->middleware('auth:sanctum');
    Route::get('get-list-classroom', [ClassroomController::class, 'getClassroom'])->middleware('auth:sanctum');
    //Classroom Announcement Route
    Route::post('add-class-announcement', [ClassroomAnnouncementController::class, 'addAnnouncement'])->middleware('auth:sanctum');
    Route::post('update-class-announcement/{id}', [ClassroomAnnouncementController::class, 'updateAnnouncement'])->middleware('auth:sanctum');
    Route::delete('delete-class-announcement/{id}', [ClassroomAnnouncementController::class, 'deleteAnnouncement'])->middleware('auth:sanctum');
    //Branch Route
    Route::post('add-branch', [BranchController::class, 'addBranch'])->middleware('auth:sanctum');
    Route::post('update-branch/{id}', [BranchController::class, 'updateBranch'])->middleware('auth:sanctum');
    Route::delete('delete-branch/{id}', [BranchController::class, 'deleteBranch'])->middleware('auth:sanctum');
    Route::get('get-list-branch', [BranchController::class, 'getBranch'])->middleware('auth:sanctum');
    Route::post('get-list-branch-by-classroom', [BranchController::class, 'getBranchByClassroomId'])->middleware('auth:sanctum');
    //Lesson Route
    Route::post('add-lesson', [LessonController::class, 'addLesson'])->middleware('auth:sanctum');
    Route::post('update-lesson/{id}', [LessonController::class, 'updateLesson'])->middleware('auth:sanctum');
    Route::delete('delete-lesson/{id}', [LessonController::class, 'deleteLesson'])->middleware('auth:sanctum');
    Route::get('get-list-lesson', [LessonController::class, 'getAllLessons'])->middleware('auth:sanctum');
    Route::post('get-list-lesson-by-classroom', [LessonController::class, 'getlessonsByClassroom'])->middleware('auth:sanctum');
    Route::post('get-list-lesson-by-branch', [LessonController::class, 'getLessonsByBranch'])->middleware('auth:sanctum');
    //Book Route
    Route::post('add-book', [BookController::class, 'AddBook'])->middleware('auth:sanctum');
    Route::post('update-book/{id}', [BookController::class, 'updateBook'])->middleware('auth:sanctum');
    Route::delete('delete-book/{id}', [BookController::class, 'deleteBook'])->middleware('auth:sanctum');
    
    
});
Route::group([
    'prefix' => 'teacher'
], function () {
    //Branch Announcement Route
    Route::post('add-branch-announcement', [BranchAnnouncementController::class, 'addAnnouncement'])->middleware('auth:sanctum');
    Route::post('update-branch-announcement/{id}', [BranchAnnouncementController::class, 'updateAnnouncement'])->middleware('auth:sanctum');
    Route::delete('delete-branch-announcement/{id}', [BranchAnnouncementController::class, 'deleteAnnouncement'])->middleware('auth:sanctum');
    
});
Route::group([
    'prefix' => 'student'
], function () {

});
Route::group([
    'prefix' => 'parent'
], function () {

});
