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
Route::put('/manageStudents/add', 'ManageStudentsController@add');
Route::put('/manageStudents/graduate', 'ManageStudentsController@graduate');
Route::put('/manageStudents/active', 'ManageStudentsController@active');
Route::get('/manageStudents/upload', 'ManageStudentsController@upload');
Route::put('/manageStudents/uploadresults', 'ManageStudentsController@uploadresults');

Route::get('/manageCurriculum', 'ManageCurriculumController@index');
Route::post('/manageCurriculum/editSubject', 'ManageCurriculumController@editSubject');
Route::post('/manageCurriculum/createNewYear', 'ManageCurriculumController@createNewYear');
Route::put('/manageCurriculum/importFromPrevious', 'ManageCurriculumController@importFromPrevious');
Route::post('/manageCurriculum/createNewSubject', 'ManageCurriculumController@createNewSubject');
Route::get('/manageCurriculum/{year}', 'ManageCurriculumController@editWithYear');
//Route::post('/manageCurriculum/edit', 'ManageCurriculumController@edit');

Route::get('/manageTeachers', 'ManageTeachersController@index');
Route::put('/manageTeachers/update', 'ManageTeachersController@update');
Route::put('/manageTeachers/add', 'ManageTeachersController@add');

Route::get('/manageAcademic', 'ManageAcademicController@editCurAcademicYear');
Route::post('/manageAcademic/changeSelYear', 'ManageAcademicController@changeEditAcademicYear');
Route::post('/manageAcademic/addNewAca', 'ManageAcademicController@addNewAcademic');
Route::post('/manageAcademic/activeAcademicYear', 'ManageAcademicController@activeAcademicYear');
Route::get('/editCurrentAcademic', 'ManageAcademicController@editCurAcademicYear');
Route::get('/editAcademic/{year}', 'ManageAcademicController@editAcademicYear');
Route::get('/editSchoolDays/{year}', 'ManageAcademicController@editSchoolDays');
Route::post('/editSchoolDays/{year}', 'ManageAcademicController@editSchoolDays');

// Subject Mangement
Route::get('/assignSubject/{year}/{grade}/{room}', 'ManageAcademicController@assignSubject');
Route::post('/assignSubject/changeSelYear', 'ManageAcademicController@changeCurYear');
Route::post('/assignSubject/add', 'ManageAcademicController@addSubject');
Route::post('/assignSubject/edit', 'ManageAcademicController@editSubject');
Route::post('/assignSubject/remove', 'ManageAcademicController@removeSubject');
Route::post('/assignSubject/importFromPrevious', 'ManageAcademicController@importSubFromPrevious');
// Student Mangement
Route::get('/assignStudent/{year}/{grade}/{room}', 'ManageAcademicController@assignStudent');
Route::post('/assignStudent/add', 'ManageAcademicController@addStudent');
Route::post('/assignStudent/remove', 'ManageAcademicController@removeStudent');
Route::post('/assignStudent/importFromPrevious', 'ManageAcademicController@importStdFromPrevious');
// Teacher Mangement
Route::get('/assignTeacher/{year}/{grade}/{room}', 'ManageAcademicController@assignTeacher');
Route::post('/assignTeacher/add', 'ManageAcademicController@addTeacher');
Route::post('/assignTeacher/remove', 'ManageAcademicController@removeTeacher');
Route::post('/assignTeacher/importFromPrevious', 'ManageAcademicController@importTeacherFromPrevious');

Route::post('/manageRoom/add', 'ManageAcademicController@addRoom');
Route::post('/manageRoom/remove', 'ManageAcademicController@removeRoom');

Auth::routes();

Route::get('/uploadGrade', 'UploadGradeController@index');
Route::get('/uploadGrade/{subject}', 'UploadGradeController@showClass');
Route::get('export-file/{type}', 'UploadGradeController@exportExcel')->name('export.file');
Route::post('/uploadGrade/import', 'UploadGradeController@import');
Route::get('/upload', 'UploadGradeController@upload');
Route::post('/getUpload', 'UploadGradeController@getUpload');
Route::post('/getUploadComments', 'UploadGradeController@getUploadComments');
Route::post('/getUploadHeightAndWeight', 'UploadGradeController@getUploadHeightAndWeight');
Route::post('/getUploadBehavior', 'UploadGradeController@getUploadBehavior');
Route::post('/getUploadAttendance', 'UploadGradeController@getUploadAttendance');
Route::post('/getUploadActivities', 'UploadGradeController@getUploadActivities');
//Route::post('/uploadErrorDetail', 'UploadGradeController@getUploadBehavior');




Route::get('export-height/{type}', 'UploadGradeController@exportHeight')->name('export.height');
Route::get('export-comments/{type}', 'UploadGradeController@exportComments')->name('export.comments');
Route::get('export-behavior/{type}', 'UploadGradeController@exportBehavior')->name('export.behavior');
Route::get('export-attandance/{type}', 'UploadGradeController@exportAttandance')->name('export.attandance');
Route::get('export-activities/{type}', 'UploadGradeController@exportActivities')->name('export.activities');

Route::get('/viewGrade', 'ViewGradeController@index');
Route::put('/viewGrade/result', 'ViewGradeController@result');




Route::get('/transcript', 'TranscriptController@index');
Route::get('/transcript/room/{classroom_id}','TranscriptController@studentList');
Route::get('/exportTranscript/{student_id}/{download_all}/{folder_name}','TranscriptController@exportTranscript');
Route::get('/transcript/pdf','TranscriptController@exportTranscriptPDF');
Route::get('/transcript/pdf_all/{classroom_id}/{academic_year}','TranscriptController@exportPDFAll');




Route::get('porbar','ReportCardController@index2');

// Grade sheet route

Route::get('/export','ExportController@index');
Route::get('/export/room/{academic_year}/{semester}/{grade_level}/{room}','ExportController@show');
Route::get('/exportHeight/{classroom_id}/{curriculum_year}','ExportController@exportHeight');
Route::get('/exportComments/{classroom_id}/{curriculum_year}','ExportController@exportComments');
Route::get('/exportBehavior/{classroom_id}/{curriculum_year}','ExportController@exportBehavior');
Route::get('/exportAttandance/{classroom_id}/{curriculum_year}','ExportController@exportAttandance');
Route::get('/exportActivities/{classroom_id}/{curriculum_year}','ExportController@exportActivities');
Route::get('/export_menu','ExportController@index2');


// Report card route

Route::get('/reportCard', 'ReportCardController@index2');
Route::get('/report_card/room/{classroom_id}','ReportCardController@Room');
Route::get('/exportReportCard/{student_id}/{academic_year}/{download_all}/{folder_name}', 'ReportCardController@exportPDF')->name('export.pdf');
Route::get('/export_grade/{classroom_id}/{course_id}/{curriculum_year}','ExportController@exportExcel');
Route::get('/export_elective_course/{classroom_id}/{course_id}/{curriculum_year}','ExportController@exportElectiveCourseForm');
Route::get('/exportReportCardDownloadAll/{classroom_id}/{academic_year}','ReportCardController@exportPDFAll');



Route::get('/exportForm', 'ReportCardController@exportForm');
Route::get('/exportGrade1', 'ReportCardController@exportGrade1');
Route::get('/exportGrade2', 'ReportCardController@exportGrade2');
Route::get('/exportGrade3', 'ReportCardController@exportGrade3');

Route::get('/manageDirector', 'ManageDirectorController@index');
Route::put('/manageDirector/update', 'ManageDirectorController@update');

Route::get('/download_all', 'ExportController@download_all')->name('create-zip');
Route::get('/api', 'ViewGradeController@api');
Route::get('/api2', 'ViewGradeController@api2');
