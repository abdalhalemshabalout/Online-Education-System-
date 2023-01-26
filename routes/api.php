<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\LessonController;
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
});
Route::group([
    'prefix' => 'personal'
], function () {
    //Announcement Route
    Route::post('add-announcement', [AnnouncementController::class, 'addAnnouncement'])->middleware('auth:sanctum');
    Route::post('update-announcement/{id}', [AnnouncementController::class, 'updateAnnouncement'])->middleware('auth:sanctum');
    Route::delete('delete-announcement/{id}', [AnnouncementController::class, 'deleteAnnouncement'])->middleware('auth:sanctum');
    Route::get('get-list-announcement', [AnnouncementController::class, 'getAnnouncement'])->middleware('auth:sanctum');
    //Class Route
    Route::post('add-classroom', [ClassroomController::class, 'addClassroom'])->middleware('auth:sanctum');
    Route::post('update-classroom/{id}', [ClassroomController::class, 'updateClassroom'])->middleware('auth:sanctum');
    Route::delete('delete-classroom/{id}', [ClassroomController::class, 'deleteClassroom'])->middleware('auth:sanctum');
    Route::get('get-list-classroom', [ClassroomController::class, 'getClassroom'])->middleware('auth:sanctum');
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

    
});
Route::group([
    'prefix' => 'teacher'
], function () {

});
Route::group([
    'prefix' => 'student'
], function () {

});
Route::group([
    'prefix' => 'parent'
], function () {

});
