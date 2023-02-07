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
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\HomeworkController;
use App\Http\Controllers\Api\LessonAnnouncementController;
use App\Http\Controllers\Api\LessonContentController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\ListForStudentController;
use App\Http\Controllers\Api\ListForTeacherController;
use App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\Api\TestQuestionExam;
use App\Http\Controllers\Api\TextController;
use App\Http\Controllers\Api\SendHomeworkAnswerController;
use App\Http\Controllers\Api\SendTestAnswerController;

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
    //Lesson Announcement Route
    Route::get('get-list-lesson-announcements/{id}', [LessonAnnouncementController::class, 'getLessonAnnouncements']);
    Route::get('get-lesson-announcement/{id}', [LessonAnnouncementController::class, 'getLessonAnnouncement']);
    //List
    Route::get('get-all-teachers', [ListForTeacherController::class, 'getAllTeachers'])->middleware('auth:sanctum');
    Route::get('get-all-students', [ListForStudentController::class, 'getAllStudents'])->middleware('auth:sanctum');
    Route::get('get-all-books', [BookController::class, 'getAllBook'])->middleware('auth:sanctum');
    Route::get('get-teacher-class/{id}', [ListForTeacherController::class, 'getTeachersByClassId'])->middleware('auth:sanctum');
    Route::get('get-teacher-branch/{id}', [ListForTeacherController::class, 'geTeachersByBranchId'])->middleware('auth:sanctum');
    Route::get('get-teacher-lesson/{id}', [ListForTeacherController::class, 'getTeachersByLessonId'])->middleware('auth:sanctum');
    Route::get('get-student-class/{id}', [ListForStudentController::class, 'getStudentsByClassId'])->middleware('auth:sanctum');
    Route::get('get-student-branch/{id}', [ListForStudentController::class, 'geStudentsByBranchId'])->middleware('auth:sanctum');
    Route::get('get-student-lesson/{id}', [ListForStudentController::class, 'getStudentsByLessonId'])->middleware('auth:sanctum');
    

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
    Route::post('add-teacher-to-branch', [BranchController::class, 'addTeacherToBranch'])->middleware('auth:sanctum');

    //Lesson Route
    Route::post('add-lesson', [LessonController::class, 'addLesson'])->middleware('auth:sanctum');
    Route::post('update-lesson/{id}', [LessonController::class, 'updateLesson'])->middleware('auth:sanctum');
    Route::delete('delete-lesson/{id}', [LessonController::class, 'deleteLesson'])->middleware('auth:sanctum');
    Route::get('get-list-lesson', [LessonController::class, 'getAllLessons'])->middleware('auth:sanctum');
    Route::post('get-list-lesson-by-classroom', [LessonController::class, 'getlessonsByClassroom'])->middleware('auth:sanctum');
    Route::post('get-list-lesson-by-branch', [LessonController::class, 'getLessonsByBranch'])->middleware('auth:sanctum');
    //Lesson Teacher Route
    Route::post('add-teacher-to-lesson', [PersonalController::class, 'AddTeacherToLesson'])->middleware('auth:sanctum');
    Route::delete('delete-teacher-from-lesson/{id}', [PersonalController::class, 'deleteTeacherFromLesson'])->middleware('auth:sanctum');
    //Lesson Student Route
    Route::post('add-student-to-lesson', [PersonalController::class, 'AddStudentToLesson'])->middleware('auth:sanctum');
    Route::delete('delete-student-from-lesson/{id}', [PersonalController::class, 'deleteStudentFromLesson'])->middleware('auth:sanctum');
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
    //Announcement Lesson 
    Route::post('add-lesson-announcement', [LessonAnnouncementController::class, 'addLessonAnnouncement'])->middleware('auth:sanctum');
    Route::post('update-lesson-announcement/{id}', [LessonAnnouncementController::class, 'updateLessonAnnouncement'])->middleware('auth:sanctum');
    Route::delete('delete-lesson-announcement/{id}', [LessonAnnouncementController::class, 'deleteLessonAnnouncement'])->middleware('auth:sanctum');
    //Lesson Content
    Route::post('add-lesson-content', [LessonContentController::class, 'addLessonContent'])->middleware('auth:sanctum');
    Route::post('update-lesson-content/{id}', [LessonContentController::class, 'updateLessonContent'])->middleware('auth:sanctum');
    Route::delete('delete-lesson-content/{id}', [LessonContentController::class, 'deleteLessonContent'])->middleware('auth:sanctum');
    Route::post('get-lesson-contents', [LessonContentController::class, 'getContentsByLessonId'])->middleware('auth:sanctum');
    //Text To Lesson Content
    Route::post('add-text', [TextController::class, 'addText'])->middleware('auth:sanctum');
    Route::post('update-text/{id}', [TextController::class, 'updateText'])->middleware('auth:sanctum');
    Route::delete('delete-text/{id}', [TextController::class, 'deleteText'])->middleware('auth:sanctum');
    Route::get('get-texts/{id}', [TextController::class, 'getTextsLessonContent'])->middleware('auth:sanctum');
    //Document To Lesson Content
    Route::post('add-document', [DocumentController::class, 'addDocument'])->middleware('auth:sanctum');
    Route::delete('delete-document/{id}', [DocumentController::class, 'deleteDocument'])->middleware('auth:sanctum');
    Route::get('get-documents/{id}', [DocumentController::class, 'getDocumentsLessonContent'])->middleware('auth:sanctum');
    //Link To Lesson Content
    Route::post('add-link', [LinkController::class, 'addLink'])->middleware('auth:sanctum');
    Route::post('update-link/{id}', [LinkController::class, 'updateLink'])->middleware('auth:sanctum');
    Route::delete('delete-link/{id}', [LinkController::class, 'deleteLink'])->middleware('auth:sanctum');
    Route::get('get-links/{id}', [LinkController::class, 'getLinksLessonContent'])->middleware('auth:sanctum');
    //Homework To Lesson Content
    Route::post('add-homework', [HomeworkController::class, 'addHomework'])->middleware('auth:sanctum');
    Route::post('update-homework/{id}', [HomeworkController::class, 'updateHomework'])->middleware('auth:sanctum');
    Route::delete('delete-homework/{id}', [HomeworkController::class, 'deleteHomework'])->middleware('auth:sanctum');
    Route::get('get-homeworks/{id}', [HomeworkController::class, 'getHomeworksLessonContent'])->middleware('auth:sanctum');
    //Exam To Lesson Content
    Route::post('add-exam', [ExamController::class, 'addExam'])->middleware('auth:sanctum');
    Route::post('update-exam/{id}', [ExamController::class, 'updateExam'])->middleware('auth:sanctum');
    Route::delete('delete-exam/{id}', [ExamController::class, 'deleteExam'])->middleware('auth:sanctum');
    Route::get('get-exams/{id}', [ExamController::class, 'getExamsLessonContent'])->middleware('auth:sanctum');
    //Test Question To Exam
    Route::post('add-test-question', [TestQuestionExam::class, 'addTestQuestion'])->middleware('auth:sanctum');
    Route::post('update-test-question/{id}', [TestQuestionExam::class, 'updateTestQuestion'])->middleware('auth:sanctum');
    Route::delete('delete-test-question/{id}', [TestQuestionExam::class, 'deleteTestQuestion'])->middleware('auth:sanctum');
    Route::get('get-exam-questions/{id}', [TestQuestionExam::class, 'getExamQuestions'])->middleware('auth:sanctum');
    //List
    Route::get('get-teacher-lessons', [ListForTeacherController::class, 'getTeacherLessons'])->middleware('auth:sanctum');

    

    
    
});
Route::group([
    'prefix' => 'student'
], function () {
    //List
    Route::get('get-student-lessons', [ListForStudentController::class, 'getStudentLessons'])->middleware('auth:sanctum');
    Route::post('get-lesson-contents', [ListForStudentController::class, 'getContentsByLessonId'])->middleware('auth:sanctum');
    Route::get('get-homeworks/{id}', [HomeworkController::class, 'getHomeworksLessonContent'])->middleware('auth:sanctum');
    //Send Homework
    Route::post('send-homework-answer', [SendHomeworkAnswerController::class, 'sendHomework'])->middleware('auth:sanctum');
    Route::post('update-homework-answer/{id}', [SendHomeworkAnswerController::class, 'updateSendHomework'])->middleware('auth:sanctum');
    Route::delete('delete-homework-answer/{id}', [SendHomeworkAnswerController::class, 'deleteSendHomework'])->middleware('auth:sanctum');
    //Exam Question And Send Answer
    Route::post('get-question', [SendTestAnswerController::class, 'getQuestion'])->middleware('auth:sanctum');
    Route::post('send-answer', [SendTestAnswerController::class, 'sendAnswer'])->middleware('auth:sanctum');

});
Route::group([
    'prefix' => 'parent'
], function () {

});
