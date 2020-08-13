<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|*/
Route::get('', 'HomeController@index')->name('home');
Route::get('logout', 'HomeController@logout')->name('logout');
Route::get('alterar-senha', 'HomeController@alterarSenha')->name('alterar-senha');
Route::get('login', 'AuthController@showLoginForm')->name('admin.login');
Route::get('esqueceu-sua-senha', 'AuthController@showForgotPassword')->name('admin.esqueceu-sua-senha');
Route::get('cadastro', 'AuthController@showCadaster')->name('admin.cadastro');
Route::get('logout', 'AuthController@logout')->name('admin.logout');
Route::post('login/do', 'AuthController@login')->name('admin.login.do');
Route::get('', 'AdminController@index')->name('admin');
Route::resource('usuarios', 'UserController')->names('user')->parameters(['usuarios' => 'user']);
Route::resource('usuarios-pre', 'UserPreController')->names('user-pre')->parameters(['usuarios-pre' => 'user-pre']);
Route::resource('tiposModulo', 'TypeModuleController')->names('typeModule')->parameters(['tiposModulo' => 'typeModule']);
Route::resource('modulos', 'ModuleController')->names('module')->parameters(['modulos' => 'module']);
Route::resource('versao', 'VersionController')->names('version')->parameters(['versao' => 'version']);
Route::resource('permissao', 'PermissionController')->names('permission')->parameters(['permissao' => 'permission']);
Route::resource('logsAcesso', 'LogsController')->names('logs')->parameters(['logsAcesso' => 'logs']);
Route::resource('alunos', 'StudentController')->names('student')->parameters(['alunos' => 'student']);
Route::resource('cursos', 'CourseController')->names('course')->parameters(['cursos' => 'course']);
Route::resource('alunosCurso', 'StudentCourseController')->names('studentCourse')->parameters(['alunosCurso' => 'studentCourse']);