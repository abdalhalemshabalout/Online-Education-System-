<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\BranchController;

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

});
Route::group([
    'prefix' => 'personal'
], function () {

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
