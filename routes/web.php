<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/main', 'MainController@index');


Route::get('/approveGrade/{year}/{semester}', 'ApproveGradeController@index');



Route::get('/approveGrade', 'ApproveGradeController@getApprovePage');
Route::post('/approveGrade', 'ApproveGradeController@postApprovePage');
Route::post('/approveGradeAcceptAll', 'ApproveGradeController@acceptAll');
Route::post('/approveGradeAccept', 'ApproveGradeController@accept');
Route::post('/approveGradeCancelAll', 'ApproveGradeController@cancelAll');
Route::post('/approveGradeCancel', 'ApproveGradeController@cancel');
Route::post('/approveGradeDownload', 'ApproveGradeController@Download');


Route::get('/manageStudents', 'ManageStudentsController@index');
Route::put('/manageStudents/update', 'ManageStudentsController@update');

Route::get('/manageCurriculum', 'ManageCurriculumController@index');
Route::post('/manageCurriculum/editSubject', 'ManageCurriculumController@editSubject');
Route::post('/manageCurriculum/createNewYear', 'ManageCurriculumController@createNewYear');
Route::post('/manageCurriculum/importFromPrevious', 'ManageCurriculumController@importFromPrevious');
Route::post('/manageCurriculum/createNewSubject', 'ManageCurriculumController@createNewSubject');

//Route::post('/manageCurriculum/edit', 'ManageCurriculumController@edit');
Route::get('/manageCurriculum/{year}', 'ManageCurriculumController@editWithYear');

Route::get('/manageTeachers', 'ManageTeachersController@index');
Route::put('/manageTeachers/update', 'ManageTeachersController@update');


Route::get('/manageAcademic', 'ManageAcademicController@index');

Auth::routes();

Route::get('/uploadGrade', 'UploadGradeController@index');
Route::get('/uploadGrade/{subject}', 'UploadGradeController@showClass');
Route::get('export-file/{type}', 'UploadGradeController@exportExcel')->name('export.file');
Route::post('/uploadGrade/import', 'UploadGradeController@import');
Route::get('/upload', 'UploadGradeController@upload');
Route::post('/getUpload', 'UploadGradeController@getUpload');


Route::get('export-height/{type}', 'UploadGradeController@exportHeight')->name('export.height');
Route::get('export-comments/{type}', 'UploadGradeController@exportComments')->name('export.comments');
Route::get('export-behavior/{type}', 'UploadGradeController@exportBehavior')->name('export.behavior');
Route::get('export-attandance/{type}', 'UploadGradeController@exportAttandance')->name('export.attandance');
Route::get('export-activities/{type}', 'UploadGradeController@exportActivities')->name('export.activities');

Route::get('/viewGrade', 'ViewGradeController@index');
Route::put('/viewGrade/result', 'ViewGradeController@result');




Route::get('/transcript', 'TranscriptController@index');



Route::get('porbar','ReportCardController@index2');



Route::get('/export','ExportController@index');
Route::get('/export/room/{academic_year}/{semester}/{grade_level}/{room}','ExportController@show');
Route::get('/exportHeight/{classroom_id}/{curriculum_year}','ExportController@exportHeight');
Route::get('/exportComments/{classroom_id}/{curriculum_year}','ExportController@exportComments');
Route::get('/exportBehavior/{classroom_id}/{curriculum_year}','ExportController@exportBehavior');
Route::get('/exportAttandance/{classroom_id}/{curriculum_year}','ExportController@exportAttandance');
Route::get('/exportActivities/{classroom_id}/{curriculum_year}','ExportController@exportActivities');
// Route::get('/export2/{academic_year}/{semester}//','ExportController@show');
Route::get('/export_menu','ExportController@index2');


Route::get('/reportCard', 'ReportCardController@index2');
Route::get('/report_card/room/{classroom_id}','ReportCardController@Room');
Route::get('/exportReportCard/{student_id}/{academic_year}', 'ReportCardController@exportPDF')->name('export.pdf');
Route::get('/export_grade/{classroom_id}/{course_id}/{curriculum_year}','ExportController@exportExcel');
Route::get('/export_elective_course/{classroom_id}/{course_id}/{curriculum_year}','ExportController@exportElectiveCourseForm');

Route::get('/exportForm', 'ReportCardController@exportForm');
Route::get('/exportGrade1', 'ReportCardController@exportGrade1');
Route::get('/exportGrade2', 'ReportCardController@exportGrade2');
Route::get('/exportGrade3', 'ReportCardController@exportGrade3');
